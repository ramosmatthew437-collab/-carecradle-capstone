<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="max-w-2xl lg:max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="flex items-center gap-3">
                <button
    type="button"
    onclick="window.history.back()"
    class="h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 rounded-full bg-white border border-pink-100 flex items-center justify-center text-slate-500 cursor-pointer hover:bg-pink-50 transition"
>
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
</button>
                <div>
                    <h1 class="text-[19px] sm:text-2xl font-bold text-slate-900 leading-tight">SMS history</h1>
                    <p class="text-[12px] sm:text-sm text-slate-500">Reminders from your RHU</p>
                </div>
            </div>

            @if($smsNotifications->count())

                @php
                    // Display-only status label mapping — underlying $sms->status
                    // values (Sent / Pending / Failed) are never changed.
                    $smsStatus = function ($status) {
                        return match ($status) {
                            'Sent' => ['label' => 'Delivered', 'dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'],
                            'Failed' => ['label' => 'Not delivered', 'dot' => 'bg-rose-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'],
                            default => ['label' => 'Pending', 'dot' => 'bg-amber-500', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700'],
                        };
                    };

                    // Presentation-only date grouping from created_at — no schema/controller changes.
                    // Operates on the paginator's current-page collection.
                    $smsGroups = $smsNotifications->getCollection()->groupBy(function ($sms) {
                        if ($sms->created_at->isToday()) {
                            return 'Today';
                        }
                        if ($sms->created_at->isYesterday()) {
                            return 'Yesterday';
                        }
                        return 'Earlier';
                    });
                @endphp

                @foreach(['Today', 'Yesterday', 'Earlier'] as $groupLabel)

                    @if($smsGroups->has($groupLabel))

                        <div class="mt-5">

                            <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-pink-500 mb-2">
                                {{ $groupLabel }}
                            </p>

                            <div class="space-y-3">

                                @foreach($smsGroups->get($groupLabel) as $sms)

                                    @php
                                        $status = $smsStatus($sms->status);
                                    @endphp

                                    <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="h-8 w-8 flex-shrink-0 rounded-full bg-pink-50 flex items-center justify-center text-pink-500 text-[14px]">
                                                📩
                                            </div>
                                            <p class="text-[12px] sm:text-[13px] text-slate-400">
                                                {{ $groupLabel === 'Earlier'
                                                    ? $sms->created_at->format('M j') . ' · ' . $sms->created_at->format('g:i A')
                                                    : $sms->created_at->format('g:i A') }}
                                            </p>
                                        </div>

                                        <p class="text-[13px] sm:text-sm text-slate-700 leading-relaxed">
                                            {{ $sms->message }}
                                        </p>

                                        <div class="mt-3 inline-flex items-center gap-1.5 rounded-full {{ $status['bg'] }} px-2.5 py-1 text-[11px] sm:text-xs font-semibold {{ $status['text'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                            {{ $status['label'] }}
                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif

                @endforeach

                {{-- ====================================== --}}
                {{-- PAGINATION — unchanged --}}
                {{-- ====================================== --}}

                <div class="mt-6">
                    {{ $smsNotifications->links() }}
                </div>

            @else

                {{-- ====================================== --}}
                {{-- NO SMS NOTIFICATIONS — same empty state as original --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border border-pink-100 p-10 sm:p-12 text-center shadow-sm">

                    <div class="text-5xl sm:text-6xl">
                        📩
                    </div>

                    <h3 class="mt-4 text-lg sm:text-xl font-bold text-slate-900">
                        No SMS notifications
                    </h3>

                    <p class="mt-2 text-[13px] sm:text-sm text-slate-500">
                        No reminder messages have been sent yet.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>