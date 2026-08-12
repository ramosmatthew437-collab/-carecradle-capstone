<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="max-w-2xl lg:max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- Back button styled the same (decorative) way as the --}}
            {{-- other CareCradle mother pages --}}
            {{-- ====================================== --}}

            <div class="flex items-start gap-3">
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
                    <h1 class="text-[19px] sm:text-2xl font-bold text-slate-900 leading-tight">My appointments</h1>
                    <p class="text-[12px] sm:text-sm text-slate-500">Manage and track your scheduled visits</p>
                    <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">
                        {{ $appointments->total() }} {{ Str::plural('appointment', $appointments->total()) }} recorded
                    </p>
                </div>
            </div>

            @if($appointments->count())

                @php
                    // Display-only status pill styling — underlying $appointment->status
                    // values (Scheduled / Completed / Cancelled) are never changed.
                    $appointmentStatus = function ($status) {
                        return match ($status) {
                            'Scheduled' => ['dot' => 'bg-blue-500', 'bg' => 'bg-blue-50', 'text' => 'text-blue-700'],
                            'Completed' => ['dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'],
                            'Cancelled' => ['dot' => 'bg-rose-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'],
                            default => ['dot' => 'bg-slate-400', 'bg' => 'bg-slate-100', 'text' => 'text-slate-600'],
                        };
                    };

                    // Presentation-only Upcoming/Past split, computed against the
                    // paginator's current-page collection. No controller/query changes.
                    $upcoming = $appointments->getCollection()
                        ->filter(fn ($a) => \Carbon\Carbon::parse($a->appointment_date)->startOfDay()->gte(now()->startOfDay()))
                        ->sortBy(fn ($a) => \Carbon\Carbon::parse($a->appointment_date . ' ' . $a->appointment_time));

                    $past = $appointments->getCollection()
                        ->filter(fn ($a) => \Carbon\Carbon::parse($a->appointment_date)->startOfDay()->lt(now()->startOfDay()))
                        ->sortByDesc(fn ($a) => \Carbon\Carbon::parse($a->appointment_date . ' ' . $a->appointment_time));

                    // Soonest upcoming appointment on the current page.
                    // Note: since this only looks at the current pagination page,
                    // it may not reflect the true next appointment if it falls on
                    // a different page. Same limitation as the Dashboard/Prenatal
                    // "latest/next" cards — flagged, not fixed, since no controller
                    // changes were requested.
                    $nextAppointment = $upcoming->first();
                @endphp

                {{-- ====================================== --}}
                {{-- NEXT APPOINTMENT (hero) --}}
                {{-- ====================================== --}}

                @if($nextAppointment)

                    @php $nextStatus = $appointmentStatus($nextAppointment->status); @endphp

                    <div class="mt-5 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-6 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-white/10"></div>
                        <div class="absolute -right-2 bottom-3 h-16 w-16 rounded-full bg-white/10"></div>

                        <div class="relative flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-pink-50">Next appointment</p>
                        </div>

                        <h2 class="relative mt-2 text-lg sm:text-xl font-bold">
                            {{ $nextAppointment->appointment_type }}
                        </h2>

                        <p class="relative mt-1 text-[13px] sm:text-sm text-pink-50">
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('l, F d, Y') }}
                            &middot;
                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}
                        </p>

                        <div class="relative mt-3 inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-[12px] sm:text-[13px] font-semibold">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                            {{ $nextAppointment->status }}
                        </div>

                    </div>

                @else

                    <div class="mt-5 rounded-2xl bg-pink-50 border border-pink-100 px-4 py-3 flex items-center gap-3">
                        <div class="h-9 w-9 flex-shrink-0 rounded-full bg-white flex items-center justify-center text-pink-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>
                        <p class="text-[13px] sm:text-sm font-medium text-pink-700">
                            No upcoming appointments — you're all caught up.
                        </p>
                    </div>

                @endif

                {{-- ====================================== --}}
                {{-- UPCOMING --}}
                {{-- ====================================== --}}

                @if($upcoming->count())

                    <div class="mt-6">

                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-pink-500 mb-2">
                            Upcoming
                        </p>

                        <div class="space-y-3">

                            @foreach($upcoming as $appointment)

                                @php $status = $appointmentStatus($appointment->status); @endphp

                                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                    <p class="text-[14px] sm:text-[15px] font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                    </p>

                                    <p class="text-[12px] sm:text-[13px] text-slate-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        &middot;
                                        {{ $appointment->appointment_type }}
                                    </p>

                                    <div class="mt-2 inline-flex items-center gap-1.5 rounded-full {{ $status['bg'] }} px-2.5 py-1 text-[11px] sm:text-xs font-semibold {{ $status['text'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $appointment->status }}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

                {{-- ====================================== --}}
                {{-- PAST --}}
                {{-- ====================================== --}}

                @if($past->count())

                    <div class="mt-6">

                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-pink-500 mb-2">
                            Past
                        </p>

                        <div class="space-y-3">

                            @foreach($past as $appointment)

                                @php $status = $appointmentStatus($appointment->status); @endphp

                                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                    <p class="text-[14px] sm:text-[15px] font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                    </p>

                                    <p class="text-[12px] sm:text-[13px] text-slate-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        &middot;
                                        {{ $appointment->appointment_type }}
                                    </p>

                                    <div class="mt-2 inline-flex items-center gap-1.5 rounded-full {{ $status['bg'] }} px-2.5 py-1 text-[11px] sm:text-xs font-semibold {{ $status['text'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $appointment->status }}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

                {{-- ====================================== --}}
                {{-- PAGINATION — unchanged --}}
                {{-- ====================================== --}}

                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>

            @else

                {{-- ====================================== --}}
                {{-- NO APPOINTMENTS FOUND — same empty state as original --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border border-pink-100 p-10 sm:p-12 text-center shadow-sm">

                    <div class="text-5xl sm:text-6xl">
                        📅
                    </div>

                    <h2 class="mt-4 text-lg sm:text-xl font-bold text-slate-900">
                        No appointments found
                    </h2>

                    <p class="mt-2 text-[13px] sm:text-sm text-slate-500">
                        You currently have no scheduled appointments.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>