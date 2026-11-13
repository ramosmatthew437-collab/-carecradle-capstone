<?php

namespace App\Http\Controllers;

use App\Models\Infant;
use App\Models\Mother;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InfantController extends Controller
{
    /** Infant columns saved from the registration and edit forms (remarks handled separately). */
    private const INFANT_FIELDS = [
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'birth_weight',
        'birth_length',
        'head_circumference',
        'birth_status',
    ];

    public const INELIGIBLE_MESSAGE = 'This mother has no prenatal checkup recorded in CareCradle (dated today or earlier). '
        . 'Record a prenatal visit first, or register the infant under an authorized exception.';

    /** DECIMAL(5,2) storage capacity of the birth measurements (not a clinical range). */
    private const MEASUREMENT_MAX = 999.99;

    private const MEASUREMENT_MESSAGES = [
        'birth_weight.max' => 'Birth weight cannot be more than 999.99 (the most the record can store).',
        'birth_length.max' => 'Birth length cannot be more than 999.99 (the most the record can store).',
        'head_circumference.max' => 'Head circumference cannot be more than 999.99 (the most the record can store).',
        // Registration, and edits that change the birth date.
        'birth_date.before_or_equal' => "The infant's birth date cannot be in the future.",
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the infant registration form.
     *
     * Panel requirement (Rule A): registration needs at least one prenatal
     * checkup dated on or before today (Mother::hasQualifyingPrenatalCheckup).
     * Without one, the page explains why and offers Add Prenatal Visit; the
     * form is shown only for an authorized exception (?exception=1).
     */
    public function create(Request $request, Mother $mother): View
    {
        $eligible = $mother->hasQualifyingPrenatalCheckup();

        $exceptionMode = ! $eligible
            && ($request->boolean('exception') || filled($request->old('exception_mode')))
            && $this->canAuthorizeException($request);

        return view('infants.create', compact('mother', 'eligible', 'exceptionMode'));
    }

    /**
     * Store a newly registered infant.
     */
    public function store(
        Request $request,
        Mother $mother,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        // Re-checked on submit so a direct POST cannot bypass the rule.
        $eligible = $mother->hasQualifyingPrenatalCheckup();

        if (! $eligible) {
            abort_unless($this->canAuthorizeException($request), 403);

            // A normal registration form submitted for an ineligible mother
            // (e.g. a direct POST): nothing is saved; explain the rule.
            if (! $request->boolean('exception_mode') && blank($request->input('exception_reason'))) {
                return redirect()
                    ->route('infants.create', $mother)
                    ->withInput()
                    ->withErrors(['exception_reason' => self::INELIGIBLE_MESSAGE]);
            }
        }

        $rules = [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'birth_date' => 'required|date|before_or_equal:today',
            // max: DECIMAL(5,2) storage capacity, not a clinical range.
            'birth_weight' => 'required|numeric|min:0|max:' . self::MEASUREMENT_MAX,
            'birth_length' => 'required|numeric|min:0|max:' . self::MEASUREMENT_MAX,
            'head_circumference' => 'nullable|numeric|min:0|max:' . self::MEASUREMENT_MAX,
            'birth_status' => 'required|in:Alive,Stillbirth',
            'remarks' => 'nullable|string',
        ];

        // Exception details are required only when the mother is not
        // eligible; they are ignored otherwise.
        if (! $eligible) {
            $rules += [
                'exception_reason' => ['required', Rule::in(array_keys(Infant::EXCEPTION_REASONS))],
                'exception_facility' => ['nullable', 'required_if:exception_reason,other_facility', 'string', 'max:255'],
                'exception_notes' => ['required', 'string', 'min:10', 'max:1000'],
                'exception_confirm' => ['accepted'],
            ];
        }

        $validated = $request->validate($rules, [
            'exception_reason.required' => 'Choose the reason for the registration exception.',
            'exception_reason.in' => 'Choose one of the listed exception reasons.',
            'exception_facility.required_if' => 'Enter the healthcare facility where the mother received prenatal care.',
            'exception_notes.required' => 'Add supporting notes for the registration exception.',
            'exception_notes.min' => 'Supporting notes must be at least 10 characters.',
            'exception_confirm.accepted' => 'Confirm that you are authorizing this registration exception.',
        ] + self::MEASUREMENT_MESSAGES, [
            'exception_facility' => 'facility',
            'exception_notes' => 'supporting notes',
        ]);

        $exceptionBlock = $eligible ? null : Infant::buildExceptionBlock(
            $validated['exception_reason'],
            $validated['exception_facility'] ?? null,
            $validated['exception_notes'],
            $request->user()
        );

        $infant = $mother->infants()->create(array_merge(
            Arr::only($validated, self::INFANT_FIELDS),
            ['remarks' => Infant::composeRemarks($exceptionBlock, $validated['remarks'] ?? null)]
        ));

        $motherReference = $mother->mother_code ?: "Mother record #{$mother->id}";

        $activityLogger->log(
            'created',
            'Infant Management',
            $eligible
                ? "Registered an infant profile linked to {$motherReference}."
                : "Registered an infant profile linked to {$motherReference} under an authorized registration exception ("
                    . Infant::EXCEPTION_REASONS[$validated['exception_reason']] . ').',
            $infant->id
        );

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Infant registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Infant $infant): View
    {
        $infant->load([
            'mother',
            'growthMonitorings',
        ]);

        return view('infants.show', compact('infant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infant $infant): View
    {
        $infant->load('mother');

        return view('infants.edit', compact('infant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Infant $infant,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            // A changed birth date may not be in the future; an existing
            // birth date that is left unchanged does not block other edits.
            'birth_date' => $this->sameDate($request->input('birth_date'), $infant->birth_date)
                ? 'required|date'
                : 'required|date|before_or_equal:today',
            // max: DECIMAL(5,2) storage capacity, not a clinical range.
            'birth_weight' => 'required|numeric|min:0|max:' . self::MEASUREMENT_MAX,
            'birth_length' => 'required|numeric|min:0|max:' . self::MEASUREMENT_MAX,
            'head_circumference' => 'nullable|numeric|min:0|max:' . self::MEASUREMENT_MAX,
            'birth_status' => 'required|in:Alive,Stillbirth',
            'remarks' => 'nullable|string',
        ], self::MEASUREMENT_MESSAGES);

        $mother = $infant->mother;
        $motherReference = $mother
            ? ($mother->mother_code ?: "Mother record #{$mother->id}")
            : 'an unavailable mother record';

        // Existing infants stay editable regardless of prenatal history. A
        // registration exception recorded at the start of the remarks is
        // kept as stored; the form edits only the clinical remarks.
        $changes = $request->only(self::INFANT_FIELDS);

        if ($request->has('remarks')) {
            $changes['remarks'] = Infant::composeRemarks($infant->exceptionBlock(), $request->input('remarks'));
        }

        $infant->update($changes);

        $activityLogger->log(
            'updated',
            'Infant Management',
            "Updated an infant profile linked to {$motherReference}.",
            $infant->id
        );

        return redirect()
            ->route('infants.show', $infant)
            ->with('success', 'Infant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Infant $infant,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $mother = $infant->mother;

        // Keep the reference before deleting the infant.
        $infantId = $infant->id;
        $motherReference = $mother
            ? ($mother->mother_code ?: "Mother record #{$mother->id}")
            : 'an unavailable mother record';

        $infant->delete();

        $activityLogger->log(
            'deleted',
            'Infant Management',
            "Deleted an infant profile linked to {$motherReference}.",
            $infantId
        );

        if ($mother) {
            return redirect()
                ->route('mothers.show', $mother)
                ->with('success', 'Infant record deleted successfully!');
        }

        return redirect()
            ->route('mothers.index')
            ->with('success', 'Infant record deleted successfully!');
    }

    /**
     * Only Midwife users may authorize a registration exception. (The infant
     * routes are already limited to Midwives who acknowledged the staff
     * confidentiality policy; this is checked again here.)
     */
    private function canAuthorizeException(Request $request): bool
    {
        return (bool) $request->user()?->isMidwife();
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