<x-app-layout>

    <x-slot name="header">
        <div class="ae-header">
            <span>Appointment Management</span>
            <h2>Edit Appointment</h2>
        </div>
    </x-slot>

    <div class="ae-page">
        <div class="ae-container">

            <div class="ae-stack">

                {{-- ====================================== --}}
                {{-- Section 1 : Hero Header --}}
                {{-- ====================================== --}}
                <section class="ae-hero">

                    <div class="ae-hero-glow ae-hero-glow-one"></div>
                    <div class="ae-hero-glow ae-hero-glow-two"></div>

                    <div class="ae-hero-inner">

                        <div class="ae-hero-main">

                            <div class="ae-hero-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />
                                </svg>
                            </div>

                            <div class="ae-hero-copy">
                                <p class="ae-eyebrow">CareCradle Appointment Management</p>

                                <h1>Edit Appointment</h1>

                                <p>
                                    Update the appointment schedule, status, consultation
                                    details, and healthcare notes while maintaining accurate
                                    maternal health records.
                                </p>
                            </div>

                        </div>

                        {{-- Patient Information --}}
                        <div class="ae-patient-card">

                            <span class="ae-patient-label">
                                Patient Information
                            </span>

                            <h2>
                                {{ $appointment->mother->first_name }}
                                {{ $appointment->mother->last_name }}
                            </h2>

                            <span class="ae-mother-code">
                                {{ $appointment->mother->mother_code }}
                            </span>

                        </div>

                    </div>
                </section>


                {{-- ====================================== --}}
                {{-- Section 2 : Validation Errors --}}
                {{-- ====================================== --}}
                @if ($errors->any())
                    <section class="ae-error-card">

                        <div class="ae-error-header">

                            <div class="ae-error-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.75a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0Z" />
                                </svg>
                            </div>

                            <div>
                                <h2>Validation Errors</h2>
                                <p>
                                    Please review the following information before updating
                                    this appointment record.
                                </p>
                            </div>

                        </div>

                        <div class="ae-error-body">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.75a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0Z" />
                                        </svg>

                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </section>
                @endif


                {{-- ====================================== --}}
                {{-- Section 3 : Appointment Form --}}
                {{-- ====================================== --}}
                <section class="ae-form-card">

                    <div class="ae-card-header">

                        <div class="ae-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0121 6v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6a2.25 2.25 0 012.25-2.25Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Appointment Information</h2>
                            <p>
                                Update the appointment schedule, status, and clinical notes
                                for this patient.
                            </p>
                        </div>

                    </div>


                    <div class="ae-form-body">

                        <form action="{{ route('appointments.update', $appointment->id) }}"
                              method="POST">

                            @csrf
                            @method('PUT')


                            {{-- Appointment Fields --}}
                            <div class="ae-fields-grid">

                                {{-- Appointment Type --}}
                                <div class="ae-field">

                                    <label for="appointment_type">
                                        Appointment Type
                                    </label>

                                    <div class="ae-input-wrap">

                                        <span class="ae-input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                            </svg>
                                        </span>

                                        <select
                                            id="appointment_type"
                                            name="appointment_type"
                                            class="ae-input ae-select">

                                            @foreach(['Prenatal Checkup', 'Vaccination', 'Postpartum Checkup'] as $type)
                                                <option value="{{ $type }}"
                                                    {{ old('appointment_type', $appointment->appointment_type) == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                {{-- Appointment Date --}}
                                <div class="ae-field">

                                    <label for="appointment_date">
                                        Appointment Date
                                    </label>

                                    <div class="ae-input-wrap">

                                        <span class="ae-input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z" />
                                            </svg>
                                        </span>

                                        <input
                                            id="appointment_date"
                                            type="date"
                                            name="appointment_date"
                                            value="{{ old('appointment_date', $appointment->appointment_date) }}"
                                            class="ae-input">

                                    </div>

                                </div>


                                {{-- Appointment Time --}}
                                <div class="ae-field">

                                    <label for="appointment_time">
                                        Appointment Time
                                    </label>

                                    <div class="ae-input-wrap">

                                        <span class="ae-input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                            </svg>
                                        </span>

                                        <input
                                            id="appointment_time"
                                            type="time"
                                            name="appointment_time"
                                            value="{{ old('appointment_time', $appointment->appointment_time) }}"
                                            class="ae-input">

                                    </div>

                                </div>


                                {{-- Status --}}
                                <div class="ae-field">

                                    <label for="status">
                                        Status
                                    </label>

                                    <div class="ae-input-wrap">

                                        <span class="ae-input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                            </svg>
                                        </span>

                                        <select
                                            id="status"
                                            name="status"
                                            class="ae-input ae-select">

                                            @foreach(['Scheduled', 'Completed', 'Cancelled', 'Missed'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', $appointment->status) == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>


                            {{-- Clinical Notes --}}
                            <div class="ae-notes-field">

                                <label for="notes">
                                    Clinical Notes
                                </label>

                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="5"
                                    placeholder="Enter clinical observations, reminders, or healthcare notes..."
                                    class="ae-textarea">{{ old('notes', $appointment->notes) }}</textarea>

                                <p class="ae-field-hint">
                                    Include relevant observations or reminders associated with
                                    this appointment.
                                </p>

                            </div>


                            {{-- ====================================== --}}
                            {{-- Section 4 : Actions --}}
                            {{-- ====================================== --}}
                            <div class="ae-actions">

                                <div class="ae-update-note">

                                    <div class="ae-update-note-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <strong>Appointment Update</strong>

                                        <p>
                                            Review the appointment details before saving.
                                            Changes will be reflected in the CareCradle
                                            medical record.
                                        </p>
                                    </div>

                                </div>


                                <div class="ae-action-buttons">

                                    {{-- Update --}}
                                    <button type="submit" class="ae-btn ae-btn-primary">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 3.75H6.75A2.25 2.25 0 004.5 6v12A2.25 2.25 0 006.75 20.25h10.5A2.25 2.25 0 0019.5 18V6.75A3 3 0 0016.5 3.75Z" />
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 3.75v4.5h6v-4.5" />
                                        </svg>

                                        Update Appointment

                                    </button>


                                    {{-- Back --}}
                                    <a
                                        href="{{ route('appointments.show', $appointment->id) }}"
                                        class="ae-btn ae-btn-secondary">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                        </svg>

                                        Back to Appointment

                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </section>

            </div>

        </div>
    </div>

</x-app-layout>