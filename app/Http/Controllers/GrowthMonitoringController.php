<?php

namespace App\Http\Controllers;

use App\Models\GrowthMonitoring;
use App\Models\Infant;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GrowthMonitoringController extends Controller
{
    /**
     * Storage limit of the DECIMAL(5,2) measurement columns. This is a
     * technical safeguard against database errors, not a clinical range.
     */
    private const MEASUREMENT_MAX = 999.99;

    private const REMARKS_MAX = 5000;

    public function create(Infant $infant)
    {
        return view('growth-monitorings.create', compact('infant'));
    }

    public function store(Request $request, Infant $infant, ActivityLogger $activityLogger)
    {
        $validated = $request->validate($this->rules($request, $infant), $this->messages($infant));

        // Age is always calculated by the server; a submitted value is ignored.
        $validated['age_in_months'] = GrowthMonitoring::completedMonths($infant->birth_date, $validated['date_measured']);

        $growthMonitoring = $infant->growthMonitorings()->create($validated);

        $activityLogger->log(
            'created',
            'Growth Monitoring',
            'Added a growth record for ' . $this->infantReference($infant) . '.',
            $growthMonitoring->id
        );

        return redirect()
            ->route('infants.show', $infant)
            ->with('success', 'Growth record added successfully.');
    }

    public function show(GrowthMonitoring $growthMonitoring)
    {
        $growthMonitoring->load('infant');

        return view('growth-monitorings.show', compact('growthMonitoring'));
    }

    public function edit(GrowthMonitoring $growthMonitoring)
    {
        $growthMonitoring->load('infant');

        return view('growth-monitorings.edit', compact('growthMonitoring'));
    }

    public function update(Request $request, GrowthMonitoring $growthMonitoring, ActivityLogger $activityLogger)
    {
        $infant = $growthMonitoring->infant;

        $validated = $request->validate(
            $this->rules($request, $infant, $growthMonitoring),
            $this->messages($infant)
        );

        // Recalculated from the birth date and measurement date. When an
        // older record's kept date cannot give an age (it is before the
        // birth date), the stored age is left as it is.
        $age = GrowthMonitoring::completedMonths($infant?->birth_date, $validated['date_measured']);
        $validated['age_in_months'] = $age ?? $growthMonitoring->age_in_months;

        $growthMonitoring->update($validated);

        $activityLogger->log(
            'updated',
            'Growth Monitoring',
            'Updated a growth record for ' . $this->infantReference($infant) . '.',
            $growthMonitoring->id
        );

        return redirect()
            ->route('growth-monitorings.show', $growthMonitoring)
            ->with('success', 'Growth record updated successfully.');
    }

    public function destroy(GrowthMonitoring $growthMonitoring, ActivityLogger $activityLogger)
    {
        $infant = $growthMonitoring->infant;
        $recordId = $growthMonitoring->id;
        $reference = $this->infantReference($infant);

        $growthMonitoring->delete();

        $activityLogger->log(
            'deleted',
            'Growth Monitoring',
            "Deleted a growth record for {$reference}.",
            $recordId
        );

        return redirect()
            ->route('infants.show', $infant)
            ->with('success', 'Growth record deleted successfully.');
    }

    /**
     * Growth record validation.
     * - Measurement date: not in the future and not before the birth date.
     * - Weight, height, head circumference: up to 999.99 (column capacity).
     * - Remarks: up to 5,000 characters.
     *
     * On edit, a stored date or remark that is left exactly as it is is not
     * re-checked, so other fields of older records can still be corrected.
     * age_in_months is not accepted from the form (calculated instead).
     */
    private function rules(Request $request, ?Infant $infant, ?GrowthMonitoring $existing = null): array
    {
        $dateUnchanged = $existing !== null
            && $this->sameDate($request->input('date_measured'), $existing->date_measured);
        $remarksUnchanged = $existing !== null
            && (string) $request->input('remarks') === (string) $existing->remarks;

        $date = ['required', 'date'];

        if (! $dateUnchanged) {
            $date[] = 'before_or_equal:today';

            if ($infant?->birth_date) {
                $date[] = 'after_or_equal:' . Carbon::parse($infant->birth_date)->toDateString();
            }
        }

        $measurement = 'numeric|min:0|max:' . self::MEASUREMENT_MAX;

        return [
            'date_measured' => $date,
            'weight' => 'required|' . $measurement,
            'height' => 'required|' . $measurement,
            'head_circumference' => 'nullable|' . $measurement,
            'remarks' => $remarksUnchanged ? 'nullable|string' : 'nullable|string|max:' . self::REMARKS_MAX,
        ];
    }

    private function messages(?Infant $infant): array
    {
        $birth = $infant?->birth_date ? Carbon::parse($infant->birth_date)->format('F d, Y') : null;
        $capacity = 'cannot be more than 999.99 (the most the record can store).';

        return [
            'date_measured.before_or_equal' => 'The measurement date cannot be in the future.',
            'date_measured.after_or_equal' => $birth
                ? "The measurement date cannot be before the infant's birth date ({$birth})."
                : "The measurement date cannot be before the infant's birth date.",
            'weight.max' => "Weight {$capacity}",
            'height.max' => "Height / length {$capacity}",
            'head_circumference.max' => "Head circumference {$capacity}",
            'remarks.max' => 'Remarks cannot be longer than 5,000 characters.',
        ];
    }

    /** Activity-log reference without personal details. */
    private function infantReference(?Infant $infant): string
    {
        if (! $infant) {
            return 'an unavailable infant record';
        }

        $motherCode = $infant->mother?->mother_code;

        return "infant record #{$infant->id}" . ($motherCode ? " linked to {$motherCode}" : '');
    }

    private function sameDate(mixed $submitted, mixed $stored): bool
    {
        if (blank($submitted) || blank($stored)) {
            return false;
        }

        try {
            return Carbon::parse($submitted)->toDateString() === Carbon::parse($stored)->toDateString();
        } catch (\Throwable) {
            return false;
        }
    }
}
