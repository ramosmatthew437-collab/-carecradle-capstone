<x-app-layout>

    <div class="smh-wrap">

        <div class="smh-container">

            {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}
            <div class="smh-page-head">

                <button
                    type="button"
                    onclick="window.history.back()"
                    aria-label="Go back"
                    class="smh-back-btn"
                >
                    <svg
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </button>

                <div class="smh-page-copy">

                    <span>Notifications</span>

                    <h1>SMS History</h1>

                    <p>
                        Reminders from your RHU
                    </p>

                </div>

            </div>


            @if($smsNotifications->count())

                @php

                    /*
                     * Presentation-only SMS status mapping.
                     * Existing database status values remain unchanged.
                     */
                    $smsStatus = function ($status) {

                        return match ($status) {

                            'Sent' => [
                                'label' => 'Delivered',
                                'dot'   => 'smh-dot-green',
                                'bg'    => 'smh-status-green',
                                'text'  => 'smh-text-green',
                            ],

                            'Failed' => [
                                'label' => 'Not delivered',
                                'dot'   => 'smh-dot-rose',
                                'bg'    => 'smh-status-rose',
                                'text'  => 'smh-text-rose',
                            ],

                            default => [
                                'label' => 'Pending',
                                'dot'   => 'smh-dot-amber',
                                'bg'    => 'smh-status-amber',
                                'text'  => 'smh-text-amber',
                            ],

                        };

                    };


                    /*
                     * Presentation-only grouping using created_at.
                     * Keeps the existing current-page behavior.
                     */
                    $smsGroups = $smsNotifications
                        ->getCollection()
                        ->groupBy(function ($sms) {

                            if ($sms->created_at->isToday()) {
                                return 'Today';
                            }

                            if ($sms->created_at->isYesterday()) {
                                return 'Yesterday';
                            }

                            return 'Earlier';

                        });

                @endphp


                {{-- =====================================================
                     SMS SUMMARY
                     ===================================================== --}}
                <div class="smh-summary">

                    <div class="smh-summary-icon">

                        <svg
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.75 10.5c0 4.556-4.366 8.25-9.75 8.25a10.8 10.8 0 01-3.733-.654L4.5 19.5l1.404-3.511A7.95 7.95 0 012.25 10.5C2.25 5.944 6.616 2.25 12 2.25s9.75 3.694 9.75 8.25Z"
                            />
                        </svg>

                    </div>

                    <div class="smh-summary-content">

                        <p>
                            RHU Messages
                        </p>

                        <strong>
                            {{ $smsNotifications->total() }}
                            {{ Str::plural('message', $smsNotifications->total()) }}
                        </strong>

                    </div>

                </div>


                {{-- =====================================================
                     MESSAGE GROUPS
                     ===================================================== --}}
                @foreach(['Today', 'Yesterday', 'Earlier'] as $groupLabel)

                    @if($smsGroups->has($groupLabel))

                        <section class="smh-section">

                            <div class="smh-section-head">

                                <div>
                                    <span>Message History</span>

                                    <h2>
                                        {{ $groupLabel }}
                                    </h2>
                                </div>

                                <span class="smh-group-count">
                                    {{ $smsGroups->get($groupLabel)->count() }}
                                </span>

                            </div>


                            <div class="smh-message-list">

                                @foreach($smsGroups->get($groupLabel) as $sms)

                                    @php
                                        $status = $smsStatus($sms->status);
                                    @endphp


                                    <article class="smh-message-card">

                                        <div class="smh-message-top">

                                            <div class="smh-message-icon">

                                                <svg
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M21.75 10.5c0 4.556-4.366 8.25-9.75 8.25a10.8 10.8 0 01-3.733-.654L4.5 19.5l1.404-3.511A7.95 7.95 0 012.25 10.5C2.25 5.944 6.616 2.25 12 2.25s9.75 3.694 9.75 8.25Z"
                                                    />
                                                </svg>

                                            </div>


                                            <div class="smh-message-meta">

                                                <p class="smh-message-source">
                                                    CareCradle RHU
                                                </p>

                                                <p class="smh-message-time">

                                                    @if($groupLabel === 'Earlier')

                                                        {{ $sms->created_at->format('M j, Y') }}
                                                        &middot;

                                                    @endif

                                                    {{ $sms->created_at->format('g:i A') }}

                                                </p>

                                            </div>


                                            <span class="smh-status {{ $status['bg'] }} {{ $status['text'] }}">

                                                <span class="smh-status-dot {{ $status['dot'] }}"></span>

                                                {{ $status['label'] }}

                                            </span>

                                        </div>


                                        <div class="smh-message-body">

                                            <p>
                                                {{ $sms->message }}
                                            </p>

                                        </div>

                                    </article>

                                @endforeach

                            </div>

                        </section>

                    @endif

                @endforeach


                {{-- =====================================================
                     PAGINATION
                     ===================================================== --}}
                @if($smsNotifications->hasPages())

                    <div class="smh-pagination">
                        {{ $smsNotifications->links() }}
                    </div>

                @endif


            @else

                {{-- =====================================================
                     EMPTY STATE
                     ===================================================== --}}
                <section class="smh-empty">

                    <div class="smh-empty-icon">

                        <svg
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.6"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.75 10.5c0 4.556-4.366 8.25-9.75 8.25a10.8 10.8 0 01-3.733-.654L4.5 19.5l1.404-3.511A7.95 7.95 0 012.25 10.5C2.25 5.944 6.616 2.25 12 2.25s9.75 3.694 9.75 8.25Z"
                            />
                        </svg>

                    </div>


                    <h2>
                        No SMS notifications
                    </h2>


                    <p>
                        No reminder messages have been sent yet.
                    </p>

                </section>

            @endif

        </div>

    </div>

</x-app-layout>