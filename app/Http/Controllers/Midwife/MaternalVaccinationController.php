<?php

namespace App\Http\Controllers\Midwife;



use App\Http\Controllers\Controller;
use App\Models\MaternalVaccination;
use App\Models\Mother;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MaternalVaccinationController extends Controller
{
    /**
     * Display the form for recording a maternal vaccination.
     */
    public function create(Mother $mother)
    {
        return view('midwife.maternal-vaccinations.create', compact('mother'));
    }

    /**
     * Store a maternal vaccination record.
     */
    public function store(Request $request, Mother $mother)
    {
        // Validate and save under a lock on the mother's row, so two
        // submissions at the same time cannot both claim the same dose in
        // her shared Td/TT series.
        DB::transaction(function () use ($request, $mother) {
            Mother::whereKey($mother->id)->lockForUpdate()->first();

            $validated = $request->validate($this->rules($request, $mother), $this->messages());

            $mother->maternalVaccinations()->create($validated);
        });

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('vaccination_success', 'Maternal vaccination record added successfully.');
    }

    /**
     * Display the form for editing a vaccination record.
     */
    public function edit(Mother $mother, MaternalVaccination $vaccination)
    {
        $vaccination = $mother->maternalVaccinations()
            ->whereKey($vaccination->id)
            ->firstOrFail();

        return view(
            'midwife.maternal-vaccinations.edit',
            compact('mother', 'vaccination')
        );
    }

    /**
     * Update an existing vaccination record.
     */
    public function update(
        Request $request,
        Mother $mother,
        MaternalVaccination $vaccination
    ) {
        $vaccination = $mother->maternalVaccinations()
            ->whereKey($vaccination->id)
            ->firstOrFail();

        DB::transaction(function () use ($request, $mother, $vaccination) {
            Mother::whereKey($mother->id)->lockForUpdate()->first();

            $validated = $request->validate($this->rules($request, $mother, $vaccination), $this->messages());

            $vaccination->update($validated);
        });

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('vaccination_success', 'Maternal vaccination record updated successfully.');
    }

    /**
     * Delete a vaccination record.
     */
    public function destroy(Mother $mother, MaternalVaccination $vaccination)
    {
        $vaccination = $mother->maternalVaccinations()
            ->whereKey($vaccination->id)
            ->firstOrFail();

        $vaccination->delete();

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('vaccination_success', 'Maternal vaccination record deleted successfully.');
    }

    /**
     * Validation for new and edited maternal vaccination records.
     *
     * Vaccine name and dose must be approved options
     * (MaternalVaccination::VACCINES / DOSES). When an existing record is
     * edited, a stored value that is left exactly as it is stays accepted
     * (legacy data is never forced to change); a changed value must be an
     * approved option. Date, administered-by, and remarks rules are unchanged.
     *
     * Shared series (RHU-confirmed): Td and TT use ONE dose sequence. A Td or
     * TT record must use the mother's next eligible dose
     * (MaternalVaccination::nextEligibleDose, computed without the record
     * being edited), which prevents duplicate and out-of-sequence doses.
     * Exception: an existing Td/TT record that keeps its own dose (even if
     * switched between Td and TT) stays valid. Legacy-named records are not
     * part of the series unless their vaccine is changed to Td or TT.
     */
    private function rules(Request $request, Mother $mother, ?MaternalVaccination $existing = null): array
    {
        $unchanged = fn (string $field) => $existing !== null
            && (string) $request->input($field) === (string) $existing->{$field};

        $vaccineName = ['required', 'string', 'max:255'];
        $dose = ['required', 'string', 'max:255'];

        if (! $unchanged('vaccine_name')) {
            $vaccineName[] = Rule::in(MaternalVaccination::VACCINES);
        }

        if (! $unchanged('dose')) {
            $dose[] = Rule::in(MaternalVaccination::DOSES);
        }

        $joinsSeries = in_array((string) $request->input('vaccine_name'), MaternalVaccination::VACCINES, true);
        $keepsOwnSeriesDose = $existing !== null && $existing->isSeriesRecord() && $unchanged('dose');

        if ($joinsSeries && ! $keepsOwnSeriesDose) {
            $eligible = MaternalVaccination::nextEligibleDose($mother->id, $existing?->id);

            $dose[] = function (string $attribute, mixed $value, \Closure $fail) use ($eligible, $unchanged) {
                // An unapproved, changed dose is already reported by Rule::in.
                if (! in_array($value, MaternalVaccination::DOSES, true) && ! $unchanged('dose')) {
                    return;
                }

                if ($eligible === null) {
                    $fail('This mother has completed the five-dose Td/TT series (Dose 5 is recorded). No further Td or TT dose can be recorded.');
                } elseif ($value !== $eligible) {
                    $fail("Td and TT share one five-dose series that continues across pregnancies. The next dose for this mother is {$eligible}.");
                }
            };
        }

        return [
            'vaccine_name' => $vaccineName,
            'dose' => $dose,
            'date_given' => 'required|date|before_or_equal:today',
            'next_due_date' => 'nullable|date|after_or_equal:date_given',
            'administered_by' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:5000',
        ];
    }

    private function messages(): array
    {
        return [
            'vaccine_name.in' => 'Please choose Tetanus-diphtheria (Td) or Tetanus toxoid (TT).',
            'dose.in' => 'Please choose a dose from Dose 1 to Dose 5.',
        ];
    }
}