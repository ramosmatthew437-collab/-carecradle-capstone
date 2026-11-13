<?php

namespace App\Http\Controllers;

use App\Models\Infant;
use App\Models\Vaccination;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    private const REMARKS_MAX = 5000;

    public function create(Infant $infant)
    {
        return view('vaccinations.create', compact('infant'));
    }

    public function store(Request $request, Infant $infant, ActivityLogger $activityLogger)
    {
  $validated = $request->validate(
        $this->rules($infant, null, $request),
        $this->messages($infant)
    );

    $vaccination = $infant->vaccinations()->create($validated);

    $activityLogger->log(
        'created',
        'Infant Vaccination',
        'Added an infant vaccination record for ' . $this->infantReference($infant) . '.',
        $vaccination->id
    );

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Vaccination record added successfully.');
    }

    public function show(Vaccination $vaccination)
    {
        $vaccination->load('infant');

    return view('vaccinations.show', compact('vaccination'));

    }

    public function edit(Vaccination $vaccination)
    {
         $vaccination->load('infant');

    return view('vaccinations.edit', compact('vaccination'));
    }

    public function update(Request $request, Vaccination $vaccination, ActivityLogger $activityLogger)
    {
         $infant = $vaccination->infant;

         $validated = $request->validate(
        $this->rules($infant, $vaccination, $request),
        $this->messages($infant)
    );

    // An unchanged vaccine or dose keeps its stored text exactly (never
    // silently rewritten, e.g. by trimming).
    foreach (['vaccine_name', 'dose'] as $field) {
        if ($this->sameText($request, $vaccination, $field)) {
            $validated[$field] = $vaccination->{$field};
        }
    }

    $vaccination->update($validated);

    $activityLogger->log(
        'updated',
        'Infant Vaccination',
        'Updated an infant vaccination record for ' . $this->infantReference($infant) . '.',
        $vaccination->id
    );

    return redirect()
        ->route('vaccinations.show', $vaccination)
        ->with('success', 'Vaccination record updated successfully.');

    }

    public function destroy(Vaccination $vaccination, ActivityLogger $activityLogger)
    {
           $infant = $vaccination->infant;
           $recordId = $vaccination->id;
           $reference = $this->infantReference($infant);

    $vaccination->delete();

    $activityLogger->log(
        'deleted',
        'Infant Vaccination',
        "Deleted an infant vaccination record for {$reference}.",
        $recordId
    );

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Vaccination record deleted successfully.');

    }

    /**
     * Validation for new and edited infant vaccination records.
     * Vaccine and dose must be an offered combination (see below). Dates:
     * - date given: not in the future and not before the infant's birth;
     * - next due date: not earlier than the date given.
     *
     * When an existing record is edited and its stored dates are left
     * unchanged, those dates are not re-checked, so other fields can still be
     * edited on older records. A changed date gets the full checks.
     */
    private function rules(?Infant $infant, ?Vaccination $existing = null, ?Request $request = null): array
    {
        $dateGivenUnchanged = $existing && $request
            && $this->sameDate($request->input('date_given'), $existing->date_given);

        $dateGiven = ['required', 'date'];

        if (! $dateGivenUnchanged) {
            $dateGiven[] = 'before_or_equal:today';

            if ($infant?->birth_date) {
                $dateGiven[] = 'after_or_equal:' . \Illuminate\Support\Carbon::parse($infant->birth_date)->toDateString();
            }
        }

        // The next due date is re-checked against the date given unless both
        // dates are kept exactly as stored.
        $nextDueUnchanged = $dateGivenUnchanged
            && (blank($request->input('next_due_date'))
                ? blank($existing->next_due_date)
                : $this->sameDate($request->input('next_due_date'), $existing->next_due_date));

        // Vaccine and dose (Vaccination::SCHEDULE). Each may be an approved
        // value or a custom text, stored exactly as entered (input is trimmed
        // by the TrimStrings middleware).
        // - New or changed text: up to VACCINE_MAX / DOSE_MAX characters, on one line.
        // - A custom name that only differs from an approved one in case or
        //   spacing ("bcg") is rejected, so standard rules cannot be bypassed.
        // - Approved vaccine: a standard dose, or a custom dose label where
        //   allowed (BCG: Birth Dose only, as before).
        // - Custom vaccine: any dose label; no schedule meaning is attached.
        // A stored value left unchanged (legacy data) is not re-checked, so
        // other fields of older records can still be edited.
        $vaccineUnchanged = $this->sameText($request, $existing, 'vaccine_name');
        $doseUnchanged = $this->sameText($request, $existing, 'dose');

        // bail: stop at the first failure (e.g. a non-text value never reaches the custom checks).
        $vaccineName = ['bail', 'required', 'string'];
        $dose = ['bail', 'required', 'string'];

        if (! $vaccineUnchanged) {
            array_push(
                $vaccineName,
                'max:' . Vaccination::VACCINE_MAX,
                'not_regex:/[\r\n\t]/',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $match = Vaccination::approvedVaccineMatching($value);

                    if ($match !== null && $match !== $value) {
                        $fail("“{$value}” matches the approved vaccine “{$match}”. Select “{$match}” from the list.");
                    }
                }
            );
        }

        if (! $doseUnchanged) {
            array_push($dose, 'max:' . Vaccination::DOSE_MAX, 'not_regex:/[\r\n\t]/');
        }

        if (! ($vaccineUnchanged && $doseUnchanged)) {
            $dose[] = function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                $vaccine = (string) $request?->input('vaccine_name');

                if (! Vaccination::isApprovedVaccine($vaccine) || Vaccination::isStandardDose($vaccine, $value)) {
                    return;
                }

                $standard = Vaccination::dosesFor($vaccine);

                if (! Vaccination::allowsCustomDose($vaccine)) {
                    $fail("The {$vaccine} vaccine can only be recorded as: " . implode(', ', $standard) . '.');
                } elseif (($match = Vaccination::standardDoseMatching($vaccine, $value)) !== null) {
                    $fail("“{$value}” matches the standard dose “{$match}”. Select “{$match}” from the dose list.");
                }
            };
        }

        return [
            'vaccine_name' => $vaccineName,
            'dose' => $dose,
            'date_given' => $dateGiven,
            'next_due_date' => $nextDueUnchanged
                ? 'nullable|date'
                : 'nullable|date|after_or_equal:date_given',
            'administered_by' => 'required|string|max:255',
            // A stored remark kept exactly as it is is not re-checked (older records).
            'remarks' => $existing && $request && (string) $request->input('remarks') === (string) $existing->remarks
                ? 'nullable|string'
                : 'nullable|string|max:' . self::REMARKS_MAX,
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

    private function messages(?Infant $infant): array
    {
        $birth = $infant?->birth_date
            ? \Illuminate\Support\Carbon::parse($infant->birth_date)->format('F d, Y')
            : null;

        return [
            'vaccine_name.required' => 'Select a vaccine from the list or type a custom vaccine name.',
            'vaccine_name.max' => 'The vaccine name cannot be longer than ' . Vaccination::VACCINE_MAX . ' characters.',
            'vaccine_name.not_regex' => 'The vaccine name must be on a single line.',
            'dose.required' => 'Select a dose from the list or type a custom dose label.',
            'dose.max' => 'The dose label cannot be longer than ' . Vaccination::DOSE_MAX . ' characters.',
            'dose.not_regex' => 'The dose label must be on a single line.',
            'date_given.before_or_equal' => 'The vaccination date cannot be in the future.',
            'date_given.after_or_equal' => $birth
                ? "The vaccination date cannot be before the infant's birth date ({$birth})."
                : "The vaccination date cannot be before the infant's birth date.",
            'next_due_date.after_or_equal' => 'The next due date cannot be earlier than the vaccination date.',
            'remarks.max' => 'Remarks cannot be longer than 5,000 characters.',
        ];
    }

    /**
     * True when an edited record's text field is submitted unchanged
     * (compared after trimming, as the TrimStrings middleware trims input).
     */
    private function sameText(?Request $request, ?Vaccination $existing, string $field): bool
    {
        return $existing !== null && $request !== null
            && trim((string) $request->input($field)) === trim((string) $existing->{$field});
    }

    /**
     * True when a submitted date is the same calendar date as the stored one.
     */
    private function sameDate(mixed $submitted, mixed $stored): bool
    {
        if (blank($submitted) || blank($stored)) {
            return false;
        }

        try {
            return \Illuminate\Support\Carbon::parse($submitted)->toDateString()
                === \Illuminate\Support\Carbon::parse($stored)->toDateString();
        } catch (\Throwable) {
            return false;
        }
    }
}