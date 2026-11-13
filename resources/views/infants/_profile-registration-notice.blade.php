{{--
    Mother Profile > Infant Records: shown instead of Register Infant when the
    mother has no prenatal checkup dated today or earlier (panel requirement,
    Rule A). Expects $mother. Inline styles, so no Vite rebuild is needed.
--}}
@once
    <style>
        .iprn {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            margin: 0 0 1.25rem;
            padding: 0.875rem 1rem;
            border: 1px solid #fde7c2;
            border-radius: 0.875rem;
            background: #fffbeb;
            color: #334155;
            font-size: 0.875rem;
            line-height: 1.55;
        }

        .iprn-icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 0.625rem;
            background: #fef3c7;
            color: #b45309;
        }

        .iprn-icon svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .iprn-title {
            margin: 0;
            color: #92400e;
            font-weight: 600;
        }

        .iprn-text {
            margin: 0.125rem 0 0;
        }

        .iprn-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem 1.25rem;
            margin-top: 0.5rem;
        }

        .iprn-links a {
            color: #be185d;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .iprn-links a:focus-visible {
            outline: 3px solid #fbcfe8;
            outline-offset: 2px;
        }
    </style>
@endonce

<div class="iprn" role="note">
    <span class="iprn-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
        </svg>
    </span>
    <div>
        <p class="iprn-title">Infant registration needs prenatal history</p>
        <p class="iprn-text">
            No prenatal checkup is recorded for this mother with a visit date of today or earlier.
            Appointments do not count.
        </p>
        <div class="iprn-links">
            <a href="{{ route('prenatal-checkups.create', $mother->id) }}">Add Prenatal Visit</a>
            <a href="{{ route('infants.create', ['mother' => $mother->id, 'exception' => 1]) }}">Register with an authorized exception</a>
        </div>
    </div>
</div>
