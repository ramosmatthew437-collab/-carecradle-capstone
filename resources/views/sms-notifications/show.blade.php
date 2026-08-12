<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            SMS Notification Details
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

                @php

                    $statusClasses = match($smsNotification->status){

                        'Pending' => 'bg-yellow-100 text-yellow-700',

                        'Sent' => 'bg-green-100 text-green-700',

                        'Failed' => 'bg-red-100 text-red-700',

                        default => 'bg-gray-100 text-gray-700',

                    };

                @endphp

                {{-- ====================================== --}}
{{-- Section 1 : Hero Header --}}
{{-- Place immediately after the @php block --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

    <div class="px-8 py-8">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-start gap-5">

                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-8 w-8 text-white">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75A2.25 2.25 0 014.5 4.5h15A2.25 2.25 0 0121.75 6.75Z"/>

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.75 7.5l-9.14 6.095a1.125 1.125 0 01-1.22 0L2.25 7.5"/>

                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        SMS Notification Details
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        CareCradle Notification Management
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Review the complete details of an SMS notification,
                        including recipient information, notification status,
                        appointment details, delivery history, and the exact
                        message transmitted through the CareCradle Electronic
                        Medical Record System.
                    </p>

                </div>

            </div>

            <div class="lg:w-80">

                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                Notification Status
                            </p>

                            <div class="mt-3">

                                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses }}">

                                    @switch($smsNotification->status)

                                        @case('Pending')
                                            Pending
                                            @break

                                        @case('Sent')
                                            Sent
                                            @break

                                        @case('Failed')
                                            Failed
                                            @break

                                        @default
                                            {{ $smsNotification->status }}

                                    @endswitch

                                </span>

                            </div>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6 text-white">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 01-1.5-1.5V6.343c0-.745.405-1.431 1.057-1.79l7.5-4.125A1.5 1.5 0 0117.25 1.74v15.51a1.5 1.5 0 01-1.5 1.5h-7.5Z"/>

                            </svg>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- Section 2 : SMS Information Card --}}
{{-- Place directly BELOW the Hero Header --}}
{{-- ====================================== --}}

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Card Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-6 w-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0121 6v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6a2.25 2.25 0 012.25-2.25Z"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    SMS Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Recipient, appointment, notification, and delivery information.
                </p>

            </div>

        </div>

    </div>

    {{-- Card Body --}}
    <div class="p-8">

        {{-- Recipient Summary --}}
        <div class="mb-8 rounded-2xl border border-pink-200 bg-pink-50 p-6">

            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                        Mother
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-gray-900">

                        {{ $smsNotification->mother->first_name }}
                        {{ $smsNotification->mother->last_name }}

                    </h3>

                    <p class="mt-2 inline-flex items-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-pink-700 shadow-sm">

                        {{ $smsNotification->mother->mother_code }}

                    </p>

                </div>

                <div>

                    <span class="inline-flex items-center rounded-full px-5 py-2 text-sm font-semibold {{ $statusClasses }}">

                        @switch($smsNotification->status)

                            @case('Pending')
                                Pending
                                @break

                            @case('Sent')
                                Sent
                                @break

                            @case('Failed')
                                Failed
                                @break

                            @default
                                {{ $smsNotification->status }}

                        @endswitch

                    </span>

                </div>

            </div>

        </div>

        {{-- Information Grid --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

            {{-- Recipient Number --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Recipient Number
                </p>

                <p class="mt-3 text-base font-semibold text-gray-900">
                    {{ $smsNotification->recipient_number }}
                </p>

            </div>

            {{-- Notification Type --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Notification Type
                </p>

                <p class="mt-3 text-base font-semibold text-gray-900">
                    {{ $smsNotification->notification_type }}
                </p>

            </div>

            {{-- Appointment Type --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Appointment Type
                </p>

                <p class="mt-3 text-base font-semibold text-gray-900">
                    {{ $smsNotification->appointment->appointment_type }}
                </p>

            </div>

            {{-- Scheduled Date --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Scheduled Date
                </p>

                <p class="mt-3 text-base font-semibold text-gray-900">
                    {{ \Carbon\Carbon::parse($smsNotification->appointment->appointment_date)->format('F d, Y') }}
                </p>

            </div>

            {{-- Scheduled Time --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Scheduled Time
                </p>

                <p class="mt-3 text-base font-semibold text-gray-900">
                    {{ \Carbon\Carbon::parse($smsNotification->appointment->appointment_time)->format('g:i A') }}
                </p>

            </div>

            {{-- Sent At --}}
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Sent At
                </p>

                @if($smsNotification->sent_at)

                    <p class="mt-3 text-base font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($smsNotification->sent_at)->format('F d, Y') }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($smsNotification->sent_at)->format('g:i A') }}
                    </p>

                @else

                    <p class="mt-3 italic text-gray-400">
                        —
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- Section 3 : SMS Message Card --}}
{{-- Place directly BELOW the SMS Information Card --}}
{{-- ====================================== --}}

<div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Card Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-6 w-6">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12.76V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v7.5A2.25 2.25 0 0119.5 21.75h-15A2.25 2.25 0 012.25 19.5v-.76M2.25 12.75l9.14 6.095a1.125 1.125 0 001.22 0l9.14-6.095M2.25 12.75L12 6.75l9.75 6"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    SMS Message
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Complete message delivered through the CareCradle SMS Notification System.
                </p>

            </div>

        </div>

    </div>

    {{-- Message Body --}}
    <div class="p-8">

        <div class="rounded-2xl border border-pink-200 bg-pink-50 p-6">

            <div class="mb-5 flex items-center justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                        Message Preview
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Outgoing SMS content sent to the recipient.
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 text-pink-600">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.625 9.75h6.75m-6.75 3h4.5m5.625-7.5H5.25A2.25 2.25 0 003 7.5v9A2.25 2.25 0 005.25 18.75h8.19a2.25 2.25 0 011.591.659l2.651 2.651a.375.375 0 00.64-.265V18.75h.428A2.25 2.25 0 0021 16.5v-9a2.25 2.25 0 00-2.25-2.25Z"/>

                    </svg>

                </div>

            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="whitespace-pre-line text-sm leading-8 text-gray-700">

                    {{ $smsNotification->message }}

                </div>

            </div>

        </div>

    </div>

</div>
                
{{-- ====================================== --}}
{{-- Section 4 : Action Button --}}
{{-- Place directly BELOW the SMS Message Card --}}
{{-- ====================================== --}}

<div class="mt-8 flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

    {{-- Information --}}
    <div class="flex items-start gap-3 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-3">

        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>

            </svg>

        </div>

        <div>

            <p class="text-sm font-semibold text-gray-900">
                Notification History
            </p>

            <p class="mt-1 text-sm leading-6 text-gray-600">
                This page displays the complete delivery details and message content of the selected SMS notification for audit and record-keeping purposes within the CareCradle Electronic Medical Record System.
            </p>

        </div>

    </div>

    {{-- Back Button --}}
    <div class="flex justify-end">

        <a
            href="{{ route('sms-notifications.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>

            </svg>

            Back to SMS Notifications

        </a>

    </div>

</div>

</div>

</div>

</div>

</x-app-layout>