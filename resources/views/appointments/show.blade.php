<x-app-layout>

    <x-slot name="header">
        <div class="apvd-header">
            <span>Maternal Health Records</span>
            <h2>Appointment Details</h2>
        </div>
    </x-slot>

    <div class="apvd-page">
        <div class="apvd-container">

            @php
                $statusClasses = match($appointment->status) {
                    'Scheduled' => 'apvd-status-scheduled',
                    'Completed' => 'apvd-status-completed',
                    'Cancelled' => 'apvd-status-cancelled',
                    'Missed' => 'apvd-status-missed',
                    default => 'apvd-status-default',
                };

                $motherStatusClasses = match($appointment->mother->status ?? null) {
                    'Pregnant' => 'apvd-status-pregnant',
                    'Delivered' => 'apvd-status-delivered',
                    'Referred' => 'apvd-status-referred',
                    default => 'apvd-status-default',
                };
            @endphp


            {{-- =========================================================
                 HERO
            ========================================================== --}}
            <section class="apvd-hero">

                <div class="apvd-hero-main">

                    <div class="apvd-hero-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>
                        </svg>
                    </div>

                    <div class="apvd-hero-copy">

                        <span class="apvd-eyebrow">
                            CareCradle Appointment Management
                        </span>

                        <h1>
                            {{ $appointment->appointment_type }}
                        </h1>

                        <p>
                            Appointment for
                            <strong>
                                {{ $appointment->mother->first_name }}
                                {{ $appointment->mother->last_name }}
                            </strong>
                        </p>

                        <div class="apvd-hero-meta">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                </svg>

                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                            </span>

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                                </svg>

                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div class="apvd-status-panel">

                    <div>
                        <span>Appointment Status</span>

                        <strong class="{{ $statusClasses }}">
                            {{ $appointment->status }}
                        </strong>
                    </div>

                    <div class="apvd-status-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>
                    </div>

                </div>

            </section>


            {{-- =========================================================
                 APPOINTMENT INFORMATION
            ========================================================== --}}
            <section class="apvd-card">

                <div class="apvd-card-header">

                    <div class="apvd-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0121 6v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6a2.25 2.25 0 012.25-2.25Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Appointment Information</h2>

                        <p>
                            Schedule details and record history for this appointment.
                        </p>
                    </div>

                </div>


                <div class="apvd-card-body">

                    <div class="apvd-detail-grid">

                        {{-- Appointment Type --}}
                        <div class="apvd-detail-item">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>

                                Appointment Type
                            </span>

                            <strong>
                                {{ $appointment->appointment_type }}
                            </strong>

                        </div>


                        {{-- Appointment Date --}}
                        <div class="apvd-detail-item">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                </svg>

                                Appointment Date
                            </span>

                            <strong>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                            </strong>

                        </div>


                        {{-- Appointment Time --}}
                        <div class="apvd-detail-item">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                                </svg>

                                Appointment Time
                            </span>

                            <strong>
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                            </strong>

                        </div>


                        {{-- Status --}}
                        <div class="apvd-detail-item">

                            <span>Status</span>

                            <strong>
                                <span class="apvd-status-badge {{ $statusClasses }}">
                                    {{ $appointment->status }}
                                </span>
                            </strong>

                        </div>


                        {{-- Created Date --}}
                        @if($appointment->created_at)

                            <div class="apvd-detail-item">

                                <span>Created Date</span>

                                <strong>
                                    {{ $appointment->created_at->format('F d, Y') }}
                                </strong>

                                <small>
                                    {{ $appointment->created_at->format('g:i A') }}
                                </small>

                            </div>

                        @endif


                        {{-- Last Updated --}}
                        @if($appointment->updated_at)

                            <div class="apvd-detail-item">

                                <span>Last Updated</span>

                                <strong>
                                    {{ $appointment->updated_at->format('F d, Y') }}
                                </strong>

                                <small>
                                    {{ $appointment->updated_at->format('g:i A') }}
                                </small>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                         CLINICAL NOTES
                    ================================================== --}}
                    <div class="apvd-notes">

                        @if($appointment->notes)

                            <div class="apvd-notes-box">

                                <div class="apvd-notes-header">

                                    <div>

                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>
                                            </svg>

                                            Clinical Notes
                                        </span>

                                        <p>
                                            Notes entered by the attending healthcare
                                            provider during this appointment.
                                        </p>

                                    </div>

                                    <div class="apvd-notes-icon">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                                        </svg>

                                    </div>

                                </div>


                                <div class="apvd-notes-content">
                                    {{ $appointment->notes }}
                                </div>

                            </div>

                        @else

                            <div class="apvd-empty-notes">

                                <div class="apvd-empty-icon">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>
                                    </svg>

                                </div>

                                <h3>No Patient Notes</h3>

                                <p>
                                    No clinical notes have been recorded for this appointment.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 MOTHER INFORMATION
            ========================================================== --}}
            <section class="apvd-card">

                <div class="apvd-card-header">

                    <div class="apvd-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Mother Information</h2>

                        <p>
                            Linked maternal record for this appointment.
                        </p>
                    </div>

                </div>


                <div class="apvd-card-body">

                    {{-- Mother Summary --}}
                    <div class="apvd-mother-summary">

                        <div class="apvd-mother-main">

                            <div class="apvd-mother-avatar">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>

                            </div>

                            <div class="apvd-mother-name">

                                <span>Mother</span>

                                <h3>
                                    {{ $appointment->mother->first_name }}
                                    {{ $appointment->mother->last_name }}
                                </h3>

                                <code>
                                    {{ $appointment->mother->mother_code }}
                                </code>

                            </div>

                        </div>


                        @if(isset($appointment->mother->status))

                            <span class="apvd-mother-status {{ $motherStatusClasses }}">
                                {{ $appointment->mother->status }}
                            </span>

                        @endif

                    </div>


                    <div class="apvd-mother-details">

                        {{-- Contact Number --}}
                        @if(isset($appointment->mother->contact_number))

                            <div class="apvd-detail-item">

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="2"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                                    </svg>

                                    Contact Number
                                </span>

                                <strong>
                                    {{ $appointment->mother->contact_number }}
                                </strong>

                            </div>

                        @endif


                        {{-- Barangay --}}
                        @if(isset($appointment->mother->barangay))

                            <div class="apvd-detail-item">

                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="2"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                                    </svg>

                                    Barangay
                                </span>

                                <strong>
                                    {{ $appointment->mother->barangay }}
                                </strong>

                            </div>

                        @endif

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 ACTIONS
            ========================================================== --}}
            <section class="apvd-action-section">

                <div class="apvd-record-note">

                    <div class="apvd-record-note-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>

                    </div>

                    <div>

                        <strong>Appointment Record</strong>

                        <p>
                            Updates to this appointment will immediately reflect
                            throughout the CareCradle Electronic Medical Record System.
                        </p>

                    </div>

                </div>


                <div class="apvd-actions">

                    {{-- Edit --}}
                    <a href="{{ route('appointments.edit', $appointment->id) }}"
                       class="apvd-btn apvd-btn-edit">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                        </svg>

                        Edit
                    </a>


                    {{-- Delete --}}
                    <form action="{{ route('appointments.destroy', $appointment->id) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this appointment?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="apvd-btn apvd-btn-delete">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6 7.5h12m-9.75 0V6a1.5 1.5 0 011.5-1.5h3A1.5 1.5 0 0114.25 6v1.5m-7.5 0v10.125A2.625 2.625 0 009.375 20.25h5.25a2.625 2.625 0 002.625-2.625V7.5M10.5 11.25v5.25m3-5.25v5.25"/>
                            </svg>

                            Delete
                        </button>

                    </form>


                    {{-- Back --}}
                    <a href="{{ route('mothers.show', $appointment->mother_id) }}"
                       class="apvd-btn apvd-btn-back">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>

                        Mother Profile
                    </a>

                </div>

            </section>

        </div>
    </div>

</x-app-layout>