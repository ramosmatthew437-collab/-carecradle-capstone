<x-app-layout>
    @include('sms-notifications._styles')

    @php

        $mother = $sms->mother;
        $when = fn ($t) => $t ? \Illuminate\Support\Carbon::parse($t)->format('M d, Y · g:i A') : null;
        $status = $sms->status;
        $explain = [
            'Pending' => ['info', 'Not sent yet', 'This reminder has not been submitted to TextBee.'],
            'Sending' => ['info', 'Sending in progress', 'This reminder is being submitted to TextBee. Refresh in a moment to see the outcome.'],
            'Sent' => ['success', 'Accepted by TextBee', $sms->delivered_at
                ? 'TextBee accepted this message and later reported it as delivered.'
                : 'TextBee accepted this message for sending. This does not by itself confirm that the phone received it.'],
            'Failed' => ['error', 'Not sent', 'TextBee did not accept this message, or it was never submitted. It can be retried once the reason below is resolved.'],
            'Unknown' => ['warning', 'Outcome unknown', 'CareCradle did not receive a clear answer from TextBee (for example, the connection timed out). TextBee may or may not have accepted the message, so it was not retried automatically. Check the phone or the TextBee dashboard, then record what you find below.'],
            'Cancelled' => ['info', 'Cancelled', 'This notification will not be sent.'],
            'Expired' => ['info', 'Expired', 'This notification will not be sent because its appointment has passed or was closed.'],
        ][$status] ?? ['info', $status, ''];
        // An interrupted send keeps its stored "Sending" status; opening this page changes nothing.
        if ($flags['stuck']) {
            $explain = ['warning', 'Sending appears interrupted', 'This send started more than ' . \App\Models\SmsNotification::STUCK_AFTER_MINUTES . ' minutes ago and no answer from TextBee was recorded. TextBee may or may not have accepted it. The automatic check (every 15 minutes) marks it Unknown so you can review it; it is never retried automatically.'];
        }
        $reviewLabels = [
            'mark_sent' => ['Mark as sent', 'You confirmed the mother received it, or TextBee shows it as sent. It will not be sent again.'],
            'mark_failed' => ['Mark as not sent', 'You confirmed it was not sent. You can then retry it.'],
            'use_current_number' => ["Use the mother's current number", 'Replace the number on this notification with her current registered number. Nothing is sent.'],
            'expire' => ['Mark as expired', 'The appointment has passed or was closed. It will not be sent.'],
            'cancel' => ['Cancel notification', 'It will not be sent. The record and its history are kept.'],
        ];
        $mismatch = $flags['mismatch'];
    @endphp

    <div class="smx">
        <div class="smx-container">

            <a href="{{ route('sms-notifications.index') }}" class="smx-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                Back to SMS Notifications
            </a>

            <header class="smx-head">
                <div class="smx-head-main">
                    <span class="smx-head-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 6 2.6-2.6A2 2 0 0 1 8 16.8h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14Z"/></svg>
                    </span>
                    <div>
                        <p class="smx-kicker">Communication Center · Notification #{{ $sms->id }}</p>
                        <h1 class="smx-title">{{ $sms->notification_type }}</h1>
                        <p class="smx-subtitle">
                            {{ $mother ? trim($mother->first_name . ' ' . $mother->last_name) . ' · ' . $mother->mother_code : 'Mother record unavailable' }}
                        </p>
                    </div>
                </div>
                <span class="smx-flags" style="margin:0">
                    <span class="smx-badge smx-s-{{ strtolower($status) }}" style="font-size:0.8125rem;padding:0.3125rem 0.75rem">{{ $status }}</span>
                    @if ($status === 'Sent' && $sms->delivered_at)
                        <span class="smx-badge smx-delivered" style="font-size:0.8125rem;padding:0.3125rem 0.75rem">Delivered</span>
                    @endif
                </span>
            </header>

            @foreach (['success' => 'Done', 'warning' => 'Please check', 'error' => 'Not done'] as $key => $heading)
                @if (session($key))
                    <div class="smx-alert smx-alert-{{ $key }}" role="{{ $key === 'success' ? 'status' : 'alert' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $key === 'success' ? 'm5 13 4 4L19 7' : 'M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z' }}"/></svg>
                        <div><strong>{{ $heading }}</strong><p>{{ session($key) }}</p></div>
                    </div>
                @endif
            @endforeach
            @if ($errors->any())
                <div class="smx-alert smx-alert-error" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01"/></svg>
                    <div><strong>Please correct the following</strong><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                </div>
            @endif

            {{-- What this status means --}}
            <div class="smx-alert smx-alert-{{ $explain[0] }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 11v5m0-8h.01"/></svg>
                <div>
                    <strong>{{ $explain[1] }}</strong>
                    <p>{{ $explain[2] }}</p>
                    @if ($sms->error_message && in_array($status, ['Failed', 'Unknown'], true))
                        <p><strong style="display:inline">Reason:</strong> {{ $sms->error_message }}</p>
                    @endif
                    @if (in_array($status, ['Cancelled', 'Expired'], true) && $sms->closedReasonLabel())
                        <p><strong style="display:inline">Reason:</strong> {{ $sms->closedReasonLabel() }}</p>
                    @endif
                    @if ($sms->status_note)
                        <p>{{ $sms->status_note }}</p>
                    @endif
                </div>
            </div>

            @php $blockers = $status === 'Pending' ? $sendBlockers : ($status === 'Failed' ? $retryBlockers : []); @endphp
            @if ($blockers)
                <div class="smx-alert smx-alert-warning" role="note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
                    <div>
                        <strong>{{ $status === 'Failed' ? 'Retry is not available yet' : 'Sending is blocked' }}</strong>
                        <ul>@foreach ($blockers as $b)<li>{{ $b }}</li>@endforeach</ul>
                    </div>
                </div>
            @endif

            <div class="smx-grid">
                <div class="smx-stack">

                    {{-- Message --}}
                    <section class="smx-card" aria-labelledby="smx-msg-title">
                        <h2 class="smx-card-title" id="smx-msg-title">Message</h2>
                        <pre class="smx-message">{{ $sms->message }}</pre>
                        <p class="smx-hint">{{ mb_strlen((string) $sms->message) }} characters. This exact text is what is submitted to TextBee.</p>
                    </section>

                    {{-- Attempt history --}}
                    <section class="smx-card" aria-labelledby="smx-hist-title">
                        <h2 class="smx-card-title" id="smx-hist-title">Attempt history <span class="smx-count">{{ $sms->attemptRecords->count() }} recorded</span></h2>
                        @if ($sms->attemptRecords->isEmpty())
                            <p class="smx-hint" style="margin:0">
                                @if ($sms->sent_at || $status === 'Failed')
                                    No attempt details were recorded for this notification. It was processed before attempt tracking was added; only the status, timestamps and error shown on this page are known.
                                @else
                                    No send attempts yet.
                                @endif
                            </p>
                        @else
                            <ol class="smx-timeline">
                                @foreach ($sms->attemptRecords as $a)
                                    <li>
                                        <div class="smx-timeline-head">
                                            Attempt {{ $a->attempt_number }}
                                            <span class="smx-badge smx-s-{{ ['accepted' => 'sent', 'rejected' => 'failed', 'not_submitted' => 'failed', 'unknown' => 'unknown', 'sending' => 'sending'][$a->outcome] ?? 'pending' }}">{{ $a->outcomeLabel() }}</span>
                                            <span @class(['smx-source', 'smx-source-auto' => $a->source === 'scheduled']) style="margin-top:0">{{ $a->sourceLabel() }}</span>
                                        </div>
                                        <p>
                                            {{ $when($a->started_at) }}
                                            @if ($a->user) · by {{ $a->user->name }} @elseif ($a->source === 'scheduled') · by the daily reminder schedule @endif
                                            · to {{ $a->recipient_masked }}
                                            @if ($a->http_status) · HTTP {{ $a->http_status }} @endif
                                        </p>
                                        @if ($a->gateway_batch_id)<p>TextBee batch: <span class="smx-mono">{{ $a->gateway_batch_id }}</span></p>@endif
                                        @if ($a->error)<p>{{ $a->error }}</p>@endif
                                        @if ($a->resolved_at)
                                            <p>Reviewed {{ $when($a->resolved_at) }}{{ $a->resolver ? ' by ' . $a->resolver->name : '' }}: {{ str_replace('_', ' ', (string) $a->resolution) }}{{ $a->resolution_note ? ' — ' . $a->resolution_note : '' }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </section>

                    {{-- Review --}}
                    @if ($reviewActions)
                        <section class="smx-card" id="review" aria-labelledby="smx-review-title">
                            <h2 class="smx-card-title" id="smx-review-title">Review</h2>
                            <form method="POST" action="{{ route('sms-notifications.review', $sms->id) }}" data-smx-submit data-busy-label="Saving…"
                                data-confirm="Apply this review decision? It will be recorded in the activity log.">
                                @csrf
                                <input type="hidden" name="seen_status" value="{{ $status }}">
                                <fieldset style="border:0;margin:0;padding:0">
                                    <legend class="smx-label" style="margin-bottom:0.5rem">Decision</legend>
                                    @foreach ($reviewActions as $i => $action)
                                        <label class="smx-choice">
                                            <input type="radio" name="action" value="{{ $action }}" @checked(old('action') === $action) required>
                                            <span><strong>{{ $reviewLabels[$action][0] }}</strong><span>{{ $reviewLabels[$action][1] }}</span></span>
                                        </label>
                                    @endforeach
                                </fieldset>
                                <div class="smx-field" style="margin-top:0.875rem">
                                    <label class="smx-label" for="smx-note">Note {{ $status === 'Unknown' ? '(required when marking sent or not sent)' : '(optional)' }}</label>
                                    <textarea id="smx-note" name="note" maxlength="250" class="smx-textarea" placeholder="e.g. Mother confirmed she received the reminder.">{{ old('note') }}</textarea>
                                    @error('note')<p class="smx-error">{{ $message }}</p>@enderror
                                </div>
                                <div style="margin-top:0.875rem">
                                    <button type="submit" class="smx-btn smx-btn-secondary">Save decision</button>
                                </div>
                            </form>
                        </section>
                    @endif
                </div>

                <div class="smx-stack">

                    {{-- Actions --}}
                    <section class="smx-card" aria-labelledby="smx-act-title">
                        <h2 class="smx-card-title" id="smx-act-title">Actions</h2>
                        <div class="smx-action-stack">
                            @if ($status === 'Pending' && ! $sendBlockers)
                                <form method="POST" action="{{ route('sms-notifications.send', $sms->id) }}" data-smx-submit data-busy-label="Sending…"
                                    data-confirm="Send this reminder to {{ $sms->maskedRecipient() }} now?">
                                    @csrf
                                    <button type="submit" class="smx-btn smx-btn-primary" style="width:100%">Send SMS</button>
                                </form>
                            @elseif ($status === 'Failed' && ! $retryBlockers)
                                <form method="POST" action="{{ route('sms-notifications.retry', $sms->id) }}" data-smx-submit data-busy-label="Retrying…"
                                    data-confirm="Try sending this message again to {{ $sms->maskedRecipient() }}?">
                                    @csrf
                                    <button type="submit" class="smx-btn smx-btn-primary" style="width:100%">Retry sending</button>
                                </form>
                            @elseif ($status === 'Sent')
                                <p class="smx-hint" style="margin:0">Already accepted by TextBee. It cannot be sent again from here.</p>
                            @elseif ($status === 'Unknown')
                                <a href="#review" class="smx-btn smx-btn-warn">Review the outcome</a>
                            @elseif (in_array($status, ['Pending', 'Failed'], true))
                                <button type="button" class="smx-btn smx-btn-primary" disabled aria-disabled="true">{{ $status === 'Failed' ? 'Retry sending' : 'Send SMS' }}</button>
                                <p class="smx-hint" style="margin:0">Resolve the issue shown above first.</p>
                            @else
                                @if ($status === 'Sending')
                                    <p class="smx-hint" style="margin:0">No actions while a send is in progress. If it was interrupted, review actions appear once the automatic check marks it Unknown.</p>
                                @elseif ($status === 'Sent')
                                    <p class="smx-hint" style="margin:0">No actions needed. TextBee accepted this message; it will not be sent again.</p>
                                @else
                                    <p class="smx-hint" style="margin:0">No actions available. This notification will not be sent.</p>
                                @endif
                            @endif

                            @if ($sms->gateway_batch_id && in_array($status, ['Sent', 'Unknown'], true))
                                <form method="POST" action="{{ route('sms-notifications.check-status', $sms->id) }}" data-smx-submit data-busy-label="Checking…">
                                    @csrf
                                    <button type="submit" class="smx-btn smx-btn-quiet" style="width:100%">Check status with TextBee</button>
                                </form>
                            @endif
                            @if ($mother)
                                <a href="{{ route('mothers.show', $mother->id) }}" class="smx-btn smx-btn-quiet">Open mother profile</a>
                            @endif
                        </div>
                    </section>

                    {{-- Overview --}}
                    <section class="smx-card" aria-labelledby="smx-ov-title">
                        <h2 class="smx-card-title" id="smx-ov-title">Overview</h2>
                        <dl class="smx-dl">
                            <dt>Status</dt><dd>{{ $status }}</dd>
                            <dt>Created</dt><dd>{{ $when($sms->created_at) }}</dd>
                            <dt>Attempts</dt><dd>{{ $sms->attempts }}</dd>
                            @if ($sms->last_attempt_at)<dt>Last attempt</dt><dd>{{ $when($sms->last_attempt_at) }}</dd>@endif
                            @php
                                $accepted = $sms->attemptRecords->where('outcome', 'accepted')->last();
                                $latestAttempt = $sms->attemptRecords->last();
                                $sourceAttempt = $accepted ?? $latestAttempt;
                            @endphp
                            <dt>{{ $accepted ? 'Sent by' : 'Last attempt by' }}</dt>
                            <dd>
                                @if ($sourceAttempt)
                                    <span @class(['smx-source', 'smx-source-auto' => $sourceAttempt->source === 'scheduled']) style="margin-top:0">{{ $sourceAttempt->sourceLabel() }}</span>
                                    {{ $sourceAttempt->source === 'scheduled' ? 'Daily reminder schedule' : ($sourceAttempt->user?->name ?? 'Midwife') }}
                                @else
                                    {{ in_array($status, ['Sent', 'Failed'], true) ? 'Not recorded (sent before tracking was added)' : 'Not sent yet' }}
                                @endif
                            </dd>
                            <dt>Accepted by TextBee</dt><dd>{{ $when($sms->sent_at) ?? '—' }}</dd>
                            <dt>Delivered</dt><dd>{{ $sms->delivered_at ? $when($sms->delivered_at) . ' (reported by TextBee)' : 'Not confirmed' }}</dd>
                            @if ($sms->reviewed_at)<dt>Reviewed</dt><dd>{{ $when($sms->reviewed_at) }}{{ $sms->reviewer ? ' by ' . $sms->reviewer->name : '' }}</dd>@endif
                        </dl>
                    </section>

                    {{-- Recipient --}}
                    <section class="smx-card" aria-labelledby="smx-rc-title">
                        <h2 class="smx-card-title" id="smx-rc-title">Recipient</h2>
                        <dl class="smx-dl">
                            <dt>Mother</dt>
                            <dd>{{ $mother ? trim($mother->first_name . ' ' . ($mother->middle_name ? $mother->middle_name . ' ' : '') . $mother->last_name) : 'Unavailable' }}</dd>
                            <dt>Mother Code</dt><dd>{{ $mother?->mother_code ?? '—' }}</dd>
                        </dl>
                        <div class="smx-compare">
                            <div @class(['smx-diff' => $mismatch])>
                                <span>Number on this notification</span>
                                <strong class="smx-mono">{{ $sms->recipient_number }}</strong>
                            </div>
                            <div @class(['smx-diff' => $mismatch])>
                                <span>Mother's current number</span>
                                <strong class="smx-mono">{{ $mother?->contact_number ?: '—' }}</strong>
                            </div>
                        </div>
                        <p class="smx-hint">
                            @if (! $mismatch)
                                The numbers match.
                            @elseif (in_array($status, ['Pending', 'Failed'], true))
                                The numbers differ. Sending is blocked until you review the recipient.
                            @else
                                The mother's number has changed since this notification was processed. This record keeps the number it was sent to.
                            @endif
                        </p>
                    </section>

                    {{-- Appointment --}}
                    <section class="smx-card" aria-labelledby="smx-ap-title">
                        <h2 class="smx-card-title" id="smx-ap-title">
                            Appointment
                            @if ($sms->appointmentWasDeleted())
                                <span class="smx-badge smx-badge-plain smx-deleted">Appointment Deleted</span>
                            @endif
                        </h2>
                        @if ($sms->appointmentWasDeleted())
                            @if ($appointment)
                                <p class="smx-hint" style="margin:0 0 0.625rem">This appointment was deleted. Details as recorded at the time of deletion:</p>
                                <dl class="smx-dl">
                                    <dt>Type</dt><dd>{{ $appointment['type'] }}</dd>
                                    <dt>Date</dt><dd>{{ \Illuminate\Support\Carbon::parse($appointment['date'])->format('l, M d, Y') }}</dd>
                                    <dt>Time</dt><dd>{{ \Illuminate\Support\Carbon::parse($appointment['time'])->format('g:i A') }}</dd>
                                    <dt>Status then</dt><dd>{{ $appointment['status'] }}</dd>
                                </dl>
                            @else
                                <p class="smx-hint" style="margin:0">This appointment was deleted before its details were recorded, so they are not available.</p>
                            @endif
                        @elseif ($appointment)
                            <dl class="smx-dl">
                                <dt>Type</dt><dd>{{ $appointment['type'] }}</dd>
                                <dt>Date</dt><dd>{{ \Illuminate\Support\Carbon::parse($appointment['date'])->format('l, M d, Y') }}</dd>
                                <dt>Time</dt><dd>{{ \Illuminate\Support\Carbon::parse($appointment['time'])->format('g:i A') }}</dd>
                                <dt>Status</dt><dd>{{ $appointment['status'] }}</dd>
                            </dl>
                            <p class="smx-hint"><a href="{{ route('appointments.show', $sms->appointment_id) }}" style="color:var(--smx-pink-700);font-weight:600">Open appointment</a></p>
                            @if ($flags['overdue'])
                                <p class="smx-hint" style="color:var(--smx-violet)">The appointment date has passed. This reminder is overdue.</p>
                            @endif
                        @else
                            <p class="smx-hint" style="margin:0">Not linked to an appointment.</p>
                        @endif
                    </section>

                    {{-- TextBee --}}
                    <section class="smx-card" aria-labelledby="smx-tb-title">
                        <h2 class="smx-card-title" id="smx-tb-title">TextBee submission</h2>
                        @if ($sms->gateway_batch_id || $sms->gateway_status_code || $sms->gateway_delivery_status)
                            <dl class="smx-dl">
                                <dt>Batch reference</dt><dd class="smx-mono">{{ $sms->gateway_batch_id ?? '—' }}</dd>
                                <dt>HTTP status</dt><dd>{{ $sms->gateway_status_code ?? '—' }}</dd>
                                <dt>Reported status</dt><dd>{{ $sms->gateway_delivery_status ? ucfirst($sms->gateway_delivery_status) : 'Not checked' }}</dd>
                                @if ($sms->delivery_checked_at)<dt>Last checked</dt><dd>{{ $when($sms->delivery_checked_at) }}</dd>@endif
                            </dl>
                        @else
                            <p class="smx-hint" style="margin:0">No TextBee submission details are recorded{{ $sms->sent_at && $sms->attempts === 0 ? ' (this notification was sent before submission tracking was added)' : '' }}.</p>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>

    @include('sms-notifications._scripts')
</x-app-layout>
