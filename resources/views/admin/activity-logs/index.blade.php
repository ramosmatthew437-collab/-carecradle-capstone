<x-app-layout>

   <link rel="stylesheet" href="{{ asset('css/activity-logs.css') }}">
    <x-slot name="header">

        <div class="al-header-shell">

            <div class="al-page-heading">

                <div class="al-page-heading-main">

                    <span class="al-page-heading-icon" aria-hidden="true">

                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"

                             viewBox="0 0 24 24" fill="none" stroke="currentColor"

                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                            <path d="M8 6h13M8 12h13M8 18h13"/>

                            <path d="M3 6h.01M3 12h.01M3 18h.01"/>

                        </svg>

                    </span>

                    <div>

                        <h1 class="al-page-heading-title">Activity Logs</h1>

                        <p class="al-page-heading-subtitle">

                            Track staff actions and system record changes.

                        </p>

                    </div>

                </div>

                <span class="al-page-heading-badge">

                    <span class="al-page-heading-dot" aria-hidden="true"></span>

                    Audit Trail

                </span>

            </div>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- SUMMARY CARDS --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                <div class="rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium text-gray-500">All Activities</p>

                        <span class="rounded-xl p-2" style="background:#fff0f6;color:#db5790;">

                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"

                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                <path d="M8 6h13M8 12h13M8 18h13"/>

                                <path d="M3 6h.01M3 12h.01M3 18h.01"/>

                            </svg>

                        </span>

                    </div>

                    <p class="mt-3 text-3xl font-bold text-gray-800">

                        {{ number_format($totalLogs) }}

                    </p>

                    <p class="mt-1 text-xs text-gray-400">Recorded since tracking began</p>

                </div>

                <div class="rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium text-gray-500">Today</p>

                        <span class="rounded-xl p-2" style="background:#fce7f3;color:#be185d;">

                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"

                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                <rect x="3" y="5" width="18" height="16" rx="2"/>

                                <path d="M16 3v4M8 3v4M3 11h18"/>

                            </svg>

                        </span>

                    </div>

                    <p class="mt-3 text-3xl font-bold text-gray-800">

                        {{ number_format($todayLogs) }}

                    </p>

                    <p class="mt-1 text-xs text-gray-400">{{ now()->format('F j, Y') }}</p>

                </div>

                <div class="rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium text-gray-500">Yesterday</p>

                        <span class="rounded-xl p-2" style="background:#fff7ed;color:#c2410c;">

                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"

                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                <circle cx="12" cy="12" r="9"/>

                                <path d="M12 7v5l3 2"/>

                            </svg>

                        </span>

                    </div>

                    <p class="mt-3 text-3xl font-bold text-gray-800">

                        {{ number_format($yesterdayLogs) }}

                    </p>

                    <p class="mt-1 text-xs text-gray-400">Activity from the previous day</p>

                </div>

                <div class="rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium text-gray-500">Matching Results</p>

                        <span class="rounded-xl p-2" style="background:#fdf2f8;color:#9d174d;">

                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"

                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                <circle cx="11" cy="11" r="7"/>

                                <path d="m20 20-4-4"/>

                            </svg>

                        </span>

                    </div>

                    <p class="mt-3 text-3xl font-bold text-gray-800">

                        {{ number_format($matchingLogs) }}

                    </p>

                    <p class="mt-1 text-xs text-gray-400">Based on your current filters</p>

                </div>

            </div>

            {{-- FILTER PANEL --}}

            <div class="rounded-2xl border border-pink-100 bg-white shadow-sm overflow-hidden">

                <div class="px-5 py-4 sm:px-6 border-b border-pink-100"

                     style="background:linear-gradient(110deg,#fff1f6,#ffffff);">

                    <h3 class="text-base font-semibold text-gray-800">Find an Activity</h3>

                    <p class="text-sm text-gray-500 mt-1">

                        Filter by date, staff member, module, or action.

                    </p>

                </div>

                <form method="GET"

                      action="{{ route('admin.activity-logs.index') }}"

                      class="p-5 sm:p-6 space-y-5">

                    {{-- DATE PRESET --}}

                    <div>

                        <label for="date_preset"

                               class="block text-sm font-semibold text-gray-700 mb-2">

                            Date Range

                        </label>

                        <select id="date_preset"

                                name="date_preset"

                                class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                            <option value="today"

                                @selected($datePreset === 'today')>

                                Today

                            </option>

                            <option value="yesterday"

                                @selected($datePreset === 'yesterday')>

                                Yesterday

                            </option>

                            <option value="last_7_days"

                                @selected($datePreset === 'last_7_days')>

                                Last 7 Days

                            </option>

                            <option value="last_30_days"

                                @selected($datePreset === 'last_30_days')>

                                Last 30 Days

                            </option>

                            <option value="custom"

                                @selected($datePreset === 'custom')>

                                Custom Date Range

                            </option>

                            <option value="all_time"

                                @selected($datePreset === 'all_time')>

                                All Time

                            </option>

                        </select>

                    </div>

                    {{-- CUSTOM DATE RANGE --}}

                    <div id="custom-date-fields"

                         class="{{ $datePreset === 'custom' ? '' : 'hidden' }} grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label for="from_date"

                                   class="block text-sm font-medium text-gray-700 mb-2">

                                From

                            </label>

                            <input type="date"

                                   id="from_date"

                                   name="from_date"

                                   value="{{ $fromDate }}"

                                   class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                        </div>

                        <div>

                            <label for="to_date"

                                   class="block text-sm font-medium text-gray-700 mb-2">

                                To

                            </label>

                            <input type="date"

                                   id="to_date"

                                   name="to_date"

                                   value="{{ $toDate }}"

                                   class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                        </div>

                    </div>

                    {{-- SEARCH AND OTHER FILTERS --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                        <div class="xl:col-span-2">

                            <label for="search"

                                   class="block text-sm font-medium text-gray-700 mb-2">

                                Search

                            </label>

                            <input type="search"

                                   id="search"

                                   name="search"

                                   value="{{ $search }}"

                                   placeholder="Name, username, description, record ID..."

                                   class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                        </div>

                        <div>

                            <label for="actor"

                                   class="block text-sm font-medium text-gray-700 mb-2">

                                Staff Member

                            </label>

                            <select id="actor"

                                    name="actor"

                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                                <option value="">All Staff</option>

                                @foreach ($actors as $staff)

                                    <option value="{{ $staff->actor_username }}"

                                        @selected($actor === $staff->actor_username)>

                                        {{ $staff->actor_name ?: $staff->actor_username }}

                                        ({{ '@' . $staff->actor_username }})

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label for="module"

                                   class="block text-sm font-medium text-gray-700 mb-2">

                                Module

                            </label>

                            <select id="module"

                                    name="module"

                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                                <option value="">All Modules</option>

                                @foreach ($modules as $moduleOption)

                                    <option value="{{ $moduleOption }}"

                                        @selected($module === $moduleOption)>

                                        {{ $moduleOption }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label for="action"

                                   class="block text-sm font-medium text-gray-700 mb-2">

                                Action

                            </label>

                            <select id="action"

                                    name="action"

                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-pink-400 focus:ring-pink-200">

                                <option value="">All Actions</option>

                                @foreach ($actions as $actionOption)

                                    <option value="{{ $actionOption }}"

                                        @selected($action === $actionOption)>

                                        {{ \Illuminate\Support\Str::headline($actionOption) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    {{-- FILTER BUTTONS --}}

                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">

                        <a href="{{ route('admin.activity-logs.index') }}"

                           class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">

                            Reset Filters

                        </a>

                        <button type="submit"

                                class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90"

                                style="background:linear-gradient(135deg,#ec4899,#be185d);">

                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"

                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                                <circle cx="11" cy="11" r="7"/>

                                <path d="m20 20-4-4"/>

                            </svg>

                            Apply Filters

                        </button>

                    </div>

                </form>

            </div>

            {{-- ACTIVITY TABLE --}}

            <div class="rounded-2xl border border-pink-100 bg-white shadow-sm overflow-hidden">

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between px-5 py-4 sm:px-6 border-b border-pink-100">

                    <div>

                        <h3 class="text-base font-semibold text-gray-800">

                            Activity History

                        </h3>

                        <p class="text-sm text-gray-500 mt-1">

                            Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }}

                            of {{ number_format($logs->total()) }} matching activities

                        </p>

                    </div>

                    <span class="text-xs font-semibold rounded-full px-3 py-1.5 self-start sm:self-auto"

                          style="background:#fff0f6;color:#be185d;">

                        Newest First

                    </span>

                </div>

                @if ($logs->isEmpty())

                    {{-- EMPTY STATE --}}

                    <div class="px-6 py-16 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl"

                             style="background:#fff0f6;color:#db5790;">

                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"

                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"

                                 stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">

                                <circle cx="11" cy="11" r="7"/>

                                <path d="m20 20-4-4"/>

                            </svg>

                        </div>

                        <h4 class="mt-4 font-semibold text-gray-800">

                            No activities found

                        </h4>

                        <p class="mt-1 text-sm text-gray-500">

                            Try another date range or remove some filters.

                        </p>

                        <a href="{{ route('admin.activity-logs.index') }}"

                           class="inline-block mt-4 text-sm font-semibold"

                           style="color:#be185d;">

                            Clear all filters

                        </a>

                    </div>

                @else

                    {{-- RESULTS TABLE --}}

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-100">

                            <thead style="background:#fff8fb;">

                                <tr>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 whitespace-nowrap">

                                        Date &amp; Time

                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">

                                        Performed By

                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">

                                        Action

                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">

                                        Module

                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 min-w-64">

                                        Activity Details

                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">

                                        Record ID

                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">

                                        IP Address

                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-100">

                                @foreach ($logs as $log)

                                    @php

                                        $displayName = $log->actor_name

                                            ?: ($log->user?->name ?: 'Deleted / system user');

                                        $displayUsername = $log->actor_username

                                            ?: $log->user?->username;

                                        $actionStyle = match (strtolower($log->action)) {

                                            'created', 'activated' => 'background:#dcfce7;color:#166534;',

                                            'updated' => 'background:#dbeafe;color:#1d4ed8;',

                                            'deleted', 'deactivated' => 'background:#fee2e2;color:#b91c1c;',

                                            default => 'background:#f3f4f6;color:#374151;',

                                        };

                                    @endphp

                                    <tr class="hover:bg-pink-50/40 transition-colors">

                                        {{-- DATE AND TIME --}}

                                        <td class="px-5 py-4 whitespace-nowrap">

                                            <p class="text-sm font-semibold text-gray-800">

                                                {{ $log->created_at->format('M d, Y') }}

                                            </p>

                                            <p class="text-xs text-gray-400 mt-1">

                                                {{ $log->created_at->format('h:i:s A') }}

                                            </p>

                                        </td>

                                        {{-- STAFF --}}

                                        <td class="px-5 py-4">

                                            <p class="text-sm font-semibold text-gray-800">

                                                {{ $displayName }}

                                            </p>

                                            @if ($displayUsername)

                                                <p class="text-xs text-gray-500 mt-1">

                                                    {{ '@' . $displayUsername }}

                                                </p>

                                            @else

                                                <p class="text-xs text-gray-400 mt-1">

                                                    Identity not recorded

                                                </p>

                                            @endif

                                        </td>

                                        {{-- ACTION --}}

                                        <td class="px-5 py-4 whitespace-nowrap">

                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"

                                                  style="{{ $actionStyle }}">

                                                {{ \Illuminate\Support\Str::headline($log->action) }}

                                            </span>

                                        </td>

                                        {{-- MODULE --}}

                                        <td class="px-5 py-4 whitespace-nowrap">

                                            <span class="text-sm font-medium text-gray-700">

                                                {{ $log->module }}

                                            </span>

                                        </td>

                                        {{-- DESCRIPTION --}}

                                        <td class="px-5 py-4">

                                            <p class="text-sm text-gray-700 leading-6">

                                                {{ $log->description }}

                                            </p>

                                        </td>

                                        {{-- RECORD ID --}}

                                        <td class="px-5 py-4 whitespace-nowrap">

                                            @if ($log->record_id)

                                                <span class="inline-flex rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-mono text-gray-600">

                                                    #{{ $log->record_id }}

                                                </span>

                                            @else

                                                <span class="text-sm text-gray-400">—</span>

                                            @endif

                                        </td>

                                        {{-- IP ADDRESS --}}

                                        <td class="px-5 py-4 whitespace-nowrap">

                                            <span class="text-xs font-mono text-gray-500">

                                                {{ $log->ip_address ?: '—' }}

                                            </span>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- PAGINATION --}}

                    <div class="border-t border-gray-100 px-5 py-4 sm:px-6">

                        {{ $logs->links() }}

                    </div>

                @endif

            </div>

            <p class="text-xs text-gray-400 text-center">

                Activity history is intended for authorized administrative review.

                Historical records may not contain actor details if they were created before identity tracking was added.

            </p>

        </div>

    </div>

    {{-- DATE RANGE INTERACTION --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const preset = document.getElementById('date_preset');

            const customFields = document.getElementById('custom-date-fields');

            function toggleCustomDates() {

                if (!preset || !customFields) {

                    return;

                }

                customFields.classList.toggle(

                    'hidden',

                    preset.value !== 'custom'

                );

            }

            if (preset) {

                preset.addEventListener('change', toggleCustomDates);

                toggleCustomDates();

            }

        });

    </script>

</x-app-layout>
