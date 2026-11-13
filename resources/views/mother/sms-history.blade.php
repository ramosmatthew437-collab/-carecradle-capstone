<x-app-layout>
    {{--
        Mother Portal: SMS History.
        Shows only the messages actually sent to the signed-in mother
        (SmsNotification::visibleToMother: status Sent), newest first by the
        time TextBee accepted them (sent_at). "Delivered" is shown only when
        TextBee confirmed delivery (delivered_at). No gateway, attempt, or
        staff-only details are loaded or shown.

        The message text is shown word for word. For readability it is laid
        out by its own blank-line paragraphs: "Label:" + value pairs (e.g.
        "Date:" / "Time:") become compact fields and a closing "-Name" line is
        shown as the signature. Styles: resources/css/mother-dashboard-polish.css
        ("SMS History" section).
    --}}

    @php
        $today = now()->startOfDay();

        // Date group for a message, by when it was sent.
        $groupOf = function ($sms) use ($today) {
            if (! $sms->sent_at) {
                return 'Date not recorded';
            }
            $day = $sms->sent_at->copy()->startOfDay();
            if ($day->equalTo($today)) {
                return 'Today';
            }
            if ($day->equalTo($today->copy()->subDay())) {
                return 'Yesterday';
            }
            return $sms->sent_at->format('F Y');
        };

        // Split the stored text into display blocks without changing any words:
        // ['text', lines] | ['field', label, value] | ['sign', line].
        $blocksOf = function (?string $message) {
            $blocks = [];
            $paragraphs = preg_split('/\R[ \t]*\R+/', trim((string) $message)) ?: [];
            foreach ($paragraphs as $paragraph) {
                $lines = array_values(array_filter(array_map('trim', preg_split('/\R/', $paragraph)), fn ($l) => $l !== ''));
                if ($lines === []) {
                    continue;
                }
                if (count($lines) === 2 && preg_match('/^([A-Za-z][A-Za-z \/]{0,24}):$/', $lines[0], $m)) {
                    $blocks[] = ['field', $m[1], $lines[1]];
                } elseif (count($lines) === 1 && preg_match('/^-\s*\S/', $lines[0])) {
                    $blocks[] = ['sign', $lines[0]];
                } else {
                    $blocks[] = ['text', $lines];
                }
            }
            return $blocks;
        };

        $fieldIcon = [
            'date' => 'M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12a1.5 1.5 0 0 1-1.5 1.5H5.25A1.5 1.5 0 0 1 3.75 18V6a1.5 1.5 0 0 1 1.5-1.5Z',
            'time' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        ];

        // Groups keep the page order (newest first).
        $groups = $smsNotifications->getCollection()->groupBy($groupOf, preserveKeys: true);
        $total = $smsNotifications->total();
    @endphp

    <div class="mdb apx shx">
        <div class="mdb-container">

            {{-- ================= HEADER + SUMMARY ================= --}}
            <section class="shx-head" aria-labelledby="shx-title">
                <div class="shx-head-main">
                    <a href="{{ route('mother.dashboard') }}" class="apx-back shx-back" aria-label="Back to dashboard">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    <div class="shx-head-copy">
                        <p class="apx-eyebrow">Messages</p>
                        <h1 class="shx-title" id="shx-title">SMS History</h1>
                        <p class="shx-lead">Appointment reminders sent to your phone by the Irosin Rural Health Unit.</p>
                    </div>
                    <p class="shx-count" aria-label="{{ $total }} {{ $total === 1 ? 'message sent' : 'messages sent' }}">
                        <strong>{{ $total }}</strong>
                        <span>{{ $total === 1 ? 'message sent' : 'messages sent' }}</span>
                    </p>
                </div>

                <dl class="shx-legend">
                    <div>
                        <dt><span class="shx-badge is-sent">Sent</span></dt>
                        <dd>Submitted successfully to the SMS service.</dd>
                    </div>
                    <div>
                        <dt><span class="shx-badge is-delivered">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Delivered
                        </span></dt>
                        <dd>Shown only when delivery to your phone was confirmed.</dd>
                    </div>
                </dl>
            </section>

            {{-- ================= MESSAGES ================= --}}
            @if($total > 0)
                @foreach($groups as $label => $messages)
                    <section class="shx-group" aria-labelledby="shx-group-{{ $loop->index }}">
                        <h2 class="shx-group-title" id="shx-group-{{ $loop->index }}">
                            <span>{{ $label }}</span>
                            <span class="shx-group-count">{{ $messages->count() }}</span>
                        </h2>

                        <ul class="shx-list">
                            @foreach($messages as $sms)
                                @php $blocks = $blocksOf($sms->message); @endphp
                                <li class="shx-message">
                                    <div class="shx-message-top">
                                        <span class="shx-message-icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 6 2.6-2.6A2 2 0 0 1 8 16.8h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14Z"/></svg>
                                        </span>
                                        <div class="shx-message-meta">
                                            <p class="shx-message-type">{{ $sms->notification_type }}</p>
                                            <p class="shx-message-time">
                                                @if($sms->sent_at)
                                                    Sent <time datetime="{{ $sms->sent_at->toIso8601String() }}">{{ $sms->sent_at->format('M d, Y · g:i A') }}</time>
                                                @else
                                                    Sent · time not recorded
                                                @endif
                                            </p>
                                        </div>
                                        @if($sms->delivered_at)
                                            <span class="shx-badge is-delivered">
                                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                Delivered
                                            </span>
                                        @else
                                            <span class="shx-badge is-sent">Sent</span>
                                        @endif
                                    </div>

                                    {{-- Message panel: the stored text, word for word. --}}
                                    <div class="shx-bubble">
                                        @php $fields = []; @endphp
                                        @foreach($blocks as $i => $block)
                                            @if($block[0] === 'field')
                                                @php $fields[] = $block; @endphp
                                                @if(! isset($blocks[$i + 1]) || $blocks[$i + 1][0] !== 'field')
                                                    <dl class="shx-fields">
                                                        @foreach($fields as $field)
                                                            @php $key = strtolower($field[1]); @endphp
                                                            <div class="shx-field">
                                                                @isset($fieldIcon[$key])
                                                                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $fieldIcon[$key] }}"/></svg>
                                                                @endisset
                                                                <dt>{{ $field[1] }}:</dt>
                                                                <dd>{{ $field[2] }}</dd>
                                                            </div>
                                                        @endforeach
                                                    </dl>
                                                    @php $fields = []; @endphp
                                                @endif
                                            @elseif($block[0] === 'sign')
                                                <p class="shx-sign">{{ $block[1] }}</p>
                                            @else
                                                <p class="shx-text">
                                                    @foreach($block[1] as $line){{ $line }}@unless($loop->last)<br>@endunless @endforeach
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>

                                    @if($sms->delivered_at)
                                        <p class="shx-delivered-note">Delivery confirmed {{ $sms->delivered_at->format('M d, Y · g:i A') }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach

                @if($smsNotifications->hasPages())
                    <nav class="apx-pagination" aria-label="SMS history pages">
                        {{ $smsNotifications->links() }}
                    </nav>
                @endif
            @else
                <section class="mdb-card shx-empty" aria-labelledby="shx-empty-title">
                    <span class="mdb-card-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 6 2.6-2.6A2 2 0 0 1 8 16.8h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14Z"/></svg>
                    </span>
                    <div>
                        <h2 class="mdb-card-title" id="shx-empty-title">No messages sent yet</h2>
                        <p class="mdb-empty-text">When the RHU sends you an appointment reminder by SMS, it will appear here.</p>
                    </div>
                </section>
            @endif

        </div>
    </div>
</x-app-layout>
