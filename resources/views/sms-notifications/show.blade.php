<x-app-layout>

    <x-slot name="header">
        <div class="sms-show-header">
            <span>Communication Center</span>
            <h2>SMS Notification Details</h2>
        </div>
    </x-slot>

    <div class="sms-show-page">

        <div class="sms-show-container">

            @php
                $statusClasses = match($smsNotification->status){
                    'Pending' => 'sms-show-status-pending',
                    'Sent' => 'sms-show-status-sent',
                    'Failed' => 'sms-show-status-failed',
                    default => 'sms-show-status-default',
                };

                $statusLabel = match($smsNotification->status){
                    'Pending' => 'Pending',
                    'Sent' => 'SMS Queued',
                    'Failed' => 'Failed',
                    default => $smsNotification->status,
                };
            @endphp


            {{-- =========================================================
                 HERO
            ========================================================== --}}

            <section class="sms-show-hero">

                <div class="sms-show-hero-decoration sms-show-decoration-one"></div>
                <div class="sms-show-hero-decoration sms-show-decoration-two"></div>

                <div class="sms-show-hero-content">

                    <div class="sms-show-hero-main">

                        <div class="sms-show-hero-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75A2.25 2.25 0 014.5 4.5h15a2.25 2.25 0 012.25 2.25Z"/>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m21.75 7.5-9.14 6.095a1.125 1.125 0 01-1.22 0L2.25 7.5"/>
                            </svg>
                        </div>

                        <div class="sms-show-hero-copy">

                            <span class="sms-show-eyebrow">
                                Communication Center
                            </span>

                            <h1>SMS Notification Details</h1>

                            <p class="sms-show-hero-subtitle">
                                CareCradle Notification Management
                            </p>

                            <p class="sms-show-hero-description">
                                Review the complete details of this SMS notification,
                                including recipient information, appointment details,
                                notification status, and the message content.
                            </p>

                        </div>

                    </div>


                    {{-- Status Panel --}}
                    <div class="sms-show-status-panel">

                        <div class="sms-show-status-heading">
                            <span>Notification Status</span>

                            <div class="sms-show-status-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M8.25 18.75a1.5 1.5 0 01-1.5-1.5V6.343c0-.745.405-1.431 1.057-1.79l7.5-4.125A1.5 1.5 0 0117.25 1.74v15.51a1.5 1.5 0 01-1.5 1.5h-7.5Z"/>
                                </svg>
                            </div>
                        </div>

                        <span class="sms-show-status {{ $statusClasses }}">
                            <span class="sms-show-status-dot"></span>
                            {{ $statusLabel }}
                        </span>

                        @if($smsNotification->status === 'Sent')
                            <p class="sms-show-status-note">
                                Queued to the SMS gateway. Delivery confirmation is not currently tracked.
                            </p>
                        @endif

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 SMS INFORMATION
            ========================================================== --}}

            <section class="sms-show-card">

                <div class="sms-show-card-header">

                    <div class="sms-show-section-icon">
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
                        <span class="sms-show-section-eyebrow">
                            Notification Record
                        </span>

                        <h2>SMS Information</h2>

                        <p>
                            Recipient, appointment, notification, and delivery information.
                        </p>
                    </div>

                </div>


                <div class="sms-show-card-body">

                    {{-- Mother Summary --}}
                    <div class="sms-show-mother-summary">

                        <div class="sms-show-mother-info">

                            <span class="sms-show-label">
                                Mother
                            </span>

                            <h3>
                                {{ $smsNotification->mother->first_name }}
                                {{ $smsNotification->mother->last_name }}
                            </h3>

                            <span class="sms-show-mother-code">
                                {{ $smsNotification->mother->mother_code }}
                            </span>

                        </div>

                        <div class="sms-show-summary-status">

                            <span class="sms-show-status {{ $statusClasses }}">
                                <span class="sms-show-status-dot"></span>
                                {{ $statusLabel }}
                            </span>

                            @if($smsNotification->status === 'Sent')
                                <p>
                                    Queued to the SMS gateway.
                                </p>
                            @endif

                        </div>

                    </div>


                    {{-- Information Grid --}}
                    <div class="sms-show-info-grid">

                        {{-- Recipient --}}
                        <div class="sms-show-info-item">

                            <div class="sms-show-info-label">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                                </svg>

                                Recipient Number
                            </div>

                            <strong>
                                {{ $smsNotification->recipient_number }}
                            </strong>

                        </div>


                        {{-- Notification Type --}}
                        <div class="sms-show-info-item">

                            <div class="sms-show-info-label">
                                Notification Type
                            </div>

                            <strong>
                                {{ $smsNotification->notification_type }}
                            </strong>

                        </div>


                        {{-- Appointment Type --}}
                        <div class="sms-show-info-item">

                            <div class="sms-show-info-label">
                                Appointment Type
                            </div>

                            <strong>
                                {{ $smsNotification->appointment->appointment_type }}
                            </strong>

                        </div>


                        {{-- Scheduled Date --}}
                        <div class="sms-show-info-item">

                            <div class="sms-show-info-label">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                </svg>

                                Scheduled Date
                            </div>

                            <strong>
                                {{ \Carbon\Carbon::parse($smsNotification->appointment->appointment_date)->format('F d, Y') }}
                            </strong>

                        </div>


                        {{-- Scheduled Time --}}
                        <div class="sms-show-info-item">

                            <div class="sms-show-info-label">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>

                                Scheduled Time
                            </div>

                            <strong>
                                {{ \Carbon\Carbon::parse($smsNotification->appointment->appointment_time)->format('g:i A') }}
                            </strong>

                        </div>


                        {{-- Sent At --}}
                        <div class="sms-show-info-item">

                            <div class="sms-show-info-label">
                                Sent At
                            </div>

                            @if($smsNotification->sent_at)

                                <strong>
                                    {{ \Carbon\Carbon::parse($smsNotification->sent_at)->format('F d, Y') }}
                                </strong>

                                <span class="sms-show-info-secondary">
                                    {{ \Carbon\Carbon::parse($smsNotification->sent_at)->format('g:i A') }}
                                </span>

                            @else

                                <strong class="sms-show-not-available">
                                    —
                                </strong>

                            @endif

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 MESSAGE
            ========================================================== --}}

            <section class="sms-show-card">

                <div class="sms-show-card-header">

                    <div class="sms-show-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M2.25 12.76V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v7.5A2.25 2.25 0 0119.5 21.75h-15A2.25 2.25 0 012.25 19.5v-.76M2.25 12.75l9.14 6.095a1.125 1.125 0 001.22 0l9.14-6.095M2.25 12.75 12 6.75l9.75 6"/>
                        </svg>
                    </div>

                    <div>
                        <span class="sms-show-section-eyebrow">
                            Message Content
                        </span>

                        <h2>SMS Message</h2>

                        <p>
                            Complete message content sent through the CareCradle SMS system.
                        </p>
                    </div>

                </div>


                <div class="sms-show-card-body">

                    <div class="sms-show-message-panel">

                        <div class="sms-show-message-heading">

                            <div>
                                <span class="sms-show-label">
                                    Message Preview
                                </span>

                                <p>
                                    Outgoing SMS content sent to the recipient.
                                </p>
                            </div>

                            <div class="sms-show-message-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M8.625 9.75h6.75m-6.75 3h4.5m5.625-7.5H5.25A2.25 2.25 0 003 7.5v9A2.25 2.25 0 005.25 18.75h8.19a2.25 2.25 0 011.591.659l2.651 2.651a.375.375 0 00.64-.265V18.75h.428A2.25 2.25 0 0021 16.5v-9a2.25 2.25 0 00-2.25-2.25Z"/>
                                </svg>
                            </div>

                        </div>


                        <div class="sms-show-message-content">
                            {{ $smsNotification->message }}
                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 FOOTER / ACTION
            ========================================================== --}}

            <section class="sms-show-footer">

                <div class="sms-show-audit-note">

                    <div class="sms-show-audit-icon">
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
                        <strong>
                            Notification History
                        </strong>

                        <p>
                            This page displays the complete delivery details and message
                            content of the selected SMS notification for audit and
                            record-keeping within the CareCradle Electronic Medical Record System.
                        </p>
                    </div>

                </div>


                <a
                    href="{{ route('sms-notifications.index') }}"
                    class="sms-show-back-btn"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.8"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>

                    <span>Back to SMS Notifications</span>
                </a>

            </section>

        </div>

    </div>

</x-app-layout>