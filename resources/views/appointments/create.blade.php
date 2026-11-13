<x-app-layout>
    @include('appointments._create-styles')

    @php
        // Same values and labels as the Appointment Edit form; the values are
        // the ones accepted by AppointmentController (appointments.appointment_type).
        $apcTypes = [
            'Prenatal Checkup' => 'Prenatal Checkup',
            'Vaccination' => 'Vaccination',
            'Postpartum' => 'Postpartum Checkup',
            'Infant Checkup' => 'Infant Checkup',
        ];

        $apcStatusClass = match ($mother->status) {
            'Pregnant' => 'apc-status-pregnant',
            'Delivered' => 'apc-status-delivered',
            'Referred' => 'apc-status-referred',
            default => 'apc-status-default',
        };

        $apcHas = fn (string $field) => $errors->has($field) ? ' has-error' : '';
        $apcInvalid = fn (string $field) => $errors->has($field) ? 'aria-invalid="true" aria-describedby="' . $field . '_error"' : '';
    @endphp

    <div class="apc">
        <div class="apc-container">

            <a href="{{ route('mothers.show', $mother->id) }}" class="apc-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Mother Profile
            </a>

            <header class="apc-head">
                <span class="apc-head-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                    </svg>
                </span>
                <div>
                    <p class="apc-kicker">Appointments</p>
                    <h1 class="apc-title">Schedule Appointment</h1>
                    <p class="apc-subtitle">Set the visit type, date, and time for this mother.</p>
                </div>
            </header>

            {{-- Mother --}}
            <section class="apc-mother" aria-label="Mother">
                <div class="apc-mother-identity">
                    <div class="apc-avatar">
                        @if ($mother->profile_photo_path)
                            <img src="{{ asset('storage/' . $mother->profile_photo_path) }}"
                                 alt="Profile photo of {{ $mother->first_name }} {{ $mother->last_name }}">
                        @else
                            <span aria-hidden="true">{{ strtoupper(substr($mother->first_name ?? '', 0, 1) . substr($mother->last_name ?? '', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="apc-mother-copy">
                        <p class="apc-mother-label">Scheduling for</p>
                        <p class="apc-mother-name">{{ $mother->first_name }} {{ $mother->last_name }}</p>
                        <div class="apc-mother-ids">
                            <span class="apc-code"><span class="apc-sr">Mother code: </span>{{ $mother->mother_code }}</span>
                            @if ($mother->barangay)
                                <span>Barangay {{ $mother->barangay }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if (filled($mother->status))
                    <span class="apc-status {{ $apcStatusClass }}"><span class="apc-sr">Status: </span>{{ $mother->status }}</span>
                @endif
            </section>

            @if ($errors->any())
                <div class="apc-alert" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>
                    <div>
                        <p class="apc-alert-title">The appointment was not scheduled</p>
                        <ul>
                            @foreach ($errors->all() as $apcError)
                                <li>{{ $apcError }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('appointments.store', $mother->id) }}" method="POST" class="apc-card">
                @csrf

                <div class="apc-card-head">
                    <h2 class="apc-card-title">Appointment Details</h2>
                    <p class="apc-card-sub">Choose the type of visit and when it will take place.</p>
                </div>

                <div class="apc-grid">
                    {{-- Appointment type --}}
                    <div class="apc-field apc-span-all{{ $apcHas('appointment_type') }}">
                        <label for="appointment_type" class="apc-label">Appointment Type <span class="apc-req">*</span></label>
                        <div class="apc-control">
                            <svg class="apc-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                            <select id="appointment_type" name="appointment_type" class="apc-input" required {!! $apcInvalid('appointment_type') !!}>
                                <option value="">Select appointment type</option>
                                @foreach ($apcTypes as $apcValue => $apcLabel)
                                    <option value="{{ $apcValue }}" @selected(old('appointment_type') === $apcValue)>{{ $apcLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('appointment_type') <p class="apc-error" id="appointment_type_error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Date --}}
                    <div class="apc-field{{ $apcHas('appointment_date') }}">
                        <label for="appointment_date" class="apc-label">Appointment Date <span class="apc-req">*</span></label>
                        <div class="apc-control">
                            <svg class="apc-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                            <input id="appointment_date" type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="apc-input" required {!! $apcInvalid('appointment_date') !!}>
                        </div>
                        @error('appointment_date') <p class="apc-error" id="appointment_date_error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Time --}}
                    <div class="apc-field{{ $apcHas('appointment_time') }}">
                        <label for="appointment_time" class="apc-label">Appointment Time <span class="apc-req">*</span></label>
                        <div class="apc-control">
                            <svg class="apc-control-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                            <input id="appointment_time" type="time" name="appointment_time" value="{{ old('appointment_time') }}" class="apc-input" required {!! $apcInvalid('appointment_time') !!}>
                        </div>
                        @error('appointment_time') <p class="apc-error" id="appointment_time_error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="apc-field apc-span-all{{ $apcHas('notes') }}">
                        <label for="notes" class="apc-label">Notes <span class="apc-optional">Optional</span></label>
                        <textarea id="notes" name="notes" rows="4" class="apc-input"
                                  placeholder="Optional notes for this appointment" {!! $apcInvalid('notes') !!}>{{ old('notes') }}</textarea>
                        @error('notes') <p class="apc-error" id="notes_error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="apc-actions">
                    <p class="apc-actions-note">
                        Fields marked <span class="apc-req">*</span> are required. Scheduling adds an appointment reminder to SMS Notifications as Pending.
                    </p>
                    <div class="apc-actions-buttons">
                        <button type="submit" class="apc-btn apc-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                            Schedule Appointment
                        </button>
                        <a href="{{ route('mothers.show', $mother->id) }}" class="apc-btn apc-btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>
                            Back to Mother Profile
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
