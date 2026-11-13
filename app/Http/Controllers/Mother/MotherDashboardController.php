<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Infant;
use App\Models\MaternalVaccination;
use App\Models\MotherReferral;
use App\Models\PrenatalCheckup;
use App\Models\SmsNotification;
use App\Models\Vaccination;
use Carbon\Carbon;

class MotherDashboardController extends Controller
{
    /** Maximum vaccination reminders listed on the dashboard. */
    private const REMINDER_LIMIT = 4;

    public function index()
    {
        $mother = auth()->user()->mother;
        $today = today();

        // Next appointment: only visits that are still Scheduled. Cancelled,
        // Completed, and Missed appointments are never shown as upcoming.
        $nextAppointment = Appointment::where('mother_id', $mother->id)
            ->where('status', 'Scheduled')
            ->whereDate('appointment_date', '>=', $today)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();

        // Summary counts (actual records of this mother).
        $appointmentCount = Appointment::where('mother_id', $mother->id)->count();
        $prenatalCount = PrenatalCheckup::where('mother_id', $mother->id)->count();
        $infantCount = Infant::where('mother_id', $mother->id)->count();
        // Same rule as her SMS History page: only messages actually sent to her.
        $smsCount = SmsNotification::where('mother_id', $mother->id)->visibleToMother()->count();

        // Pregnancy progress: only while the recorded status is Pregnant.
        // The current week still comes from the existing LMP calculation.
        $isPregnant = $mother->status === 'Pregnant';
        $pregnancyWeek = null;
        $trimester = null;
        $expectedDeliveryDate = null;

        if ($isPregnant) {
            if ($mother->last_menstrual_period) {
                $weeksSinceLmp = (int) Carbon::parse($mother->last_menstrual_period)->diffInWeeks(now());

                if ($weeksSinceLmp >= 1 && $weeksSinceLmp <= 42) {
                    $pregnancyWeek = $weeksSinceLmp;
                    $trimester = match (true) {
                        $pregnancyWeek <= 13 => '1st',
                        $pregnancyWeek <= 27 => '2nd',
                        default => '3rd',
                    };
                }
            }

            if ($mother->expected_delivery_date) {
                $expectedDeliveryDate = Carbon::parse($mother->expected_delivery_date);
            }
        }

        // All children of this mother, youngest first.
        $infants = Infant::where('mother_id', $mother->id)
            ->orderByDesc('birth_date')
            ->orderByDesc('id')
            ->get(['id', 'mother_id', 'first_name', 'last_name', 'sex', 'birth_date', 'birth_weight']);

        $infant = $infants->first();

        // Vaccination reminders (maternal + infant, upcoming and overdue).
        [$vaccinationReminders, $vaccinationReminderTotal] = $this->vaccinationReminders(
            $mother->id,
            $infants,
            $today
        );

        // Compact notice while the mother has an active referral
        // (facility and date only; never the reason or staff notes).
        $currentReferral = $mother->referrals()
            ->where('status', MotherReferral::ACTIVE)
            ->first(['id', 'mother_id', 'referred_at', 'receiving_facility']);

        return view('mother.dashboard', compact(
            'currentReferral',
            'mother',
            'nextAppointment',
            'appointmentCount',
            'prenatalCount',
            'infantCount',
            'smsCount',
            'isPregnant',
            'pregnancyWeek',
            'trimester',
            'expectedDeliveryDate',
            'infant',
            'infants',
            'vaccinationReminders',
            'vaccinationReminderTotal'
        ));
    }

    /**
     * Doses of this mother and her infants that still have an open next due
     * date. Overdue doses first (most overdue first), then upcoming doses
     * (soonest first). Returns [rows (limited), total].
     */
    private function vaccinationReminders(int $motherId, $infants, Carbon $today): array
    {
        $infantNames = $infants->pluck('first_name', 'id');

        $maternal = $this->openDoseQuery(MaternalVaccination::class, 'maternal_vaccinations', 'mother_id', [$motherId])
            ->get()
            ->map(fn ($dose) => $this->reminderRow($dose, 'You', true, $today));

        $infantRows = $infants->isEmpty()
            ? collect()
            : $this->openDoseQuery(Vaccination::class, 'vaccinations', 'infant_id', $infants->pluck('id')->all())
                ->get()
                ->map(fn ($dose) => $this->reminderRow($dose, $infantNames[$dose->infant_id] ?? 'Your child', false, $today));

        $rows = $maternal
            ->concat($infantRows)
            ->sortBy(fn ($row) => [$row['overdue'] ? 0 : 1, $row['due']->toDateString(), $row['maternal'] ? 0 : 1, $row['id']])
            ->values();

        return [$rows->take(self::REMINDER_LIMIT), $rows->count()];
    }

    /**
     * Doses with a next due date that have NOT been followed by a later dose
     * of the same vaccine for the same person. This is the same rule as the
     * Midwife dashboard's overdue list (DashboardController::pastDueDoseQuery):
     * names are compared case-insensitively ignoring spaces, and a dose counts
     * as "later" when given after this one, or on the same day but recorded
     * afterwards. Here it is applied to both overdue and upcoming doses.
     */
    private function openDoseQuery(string $model, string $table, string $ownerColumn, array $ownerIds)
    {
        $normalisedName = fn (string $alias) => "LOWER(REPLACE({$alias}.vaccine_name, ' ', ''))";

        return $model::query()
            ->from("{$table} as dose")
            ->select('dose.*')
            ->whereIn("dose.{$ownerColumn}", $ownerIds)
            ->whereNotNull('dose.next_due_date')
            ->whereNotExists(function ($later) use ($table, $ownerColumn, $normalisedName) {
                $later->selectRaw('1')
                    ->from("{$table} as later")
                    ->whereColumn("later.{$ownerColumn}", "dose.{$ownerColumn}")
                    ->whereRaw($normalisedName('later') . ' = ' . $normalisedName('dose'))
                    ->where(function ($when) {
                        $when->whereColumn('later.date_given', '>', 'dose.date_given')
                            ->orWhere(function ($sameDay) {
                                $sameDay->whereColumn('later.date_given', 'dose.date_given')
                                    ->whereColumn('later.id', '>', 'dose.id');
                            });
                    });
            });
    }

    private function reminderRow($dose, string $who, bool $maternal, Carbon $today): array
    {
        $due = Carbon::parse($dose->next_due_date)->startOfDay();
        $days = (int) $today->diffInDays($due, false);

        return [
            'id' => $dose->id,
            'who' => $who,
            'maternal' => $maternal,
            'vaccine' => $dose->vaccine_name,
            'lastDose' => $dose->dose,
            'due' => $due,
            'days' => $days,
            'overdue' => $days < 0,
        ];
    }
}
