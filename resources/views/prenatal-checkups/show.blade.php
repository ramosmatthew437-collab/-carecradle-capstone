<x-app-layout>
    @include('prenatal-checkups._styles')

    @php
        $pvVisit = $prenatalCheckup;
        $pvDate = \Carbon\Carbon::parse($pvVisit->visit_date);
        $pvNotRecorded = '<span class="pv-empty-value">Not recorded</span>';
    @endphp

    <div class="pv">
        <div class="pv-container">

            <a href="{{ route('mothers.show', $pvVisit->mother_id) }}" class="pv-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Mother Profile
            </a>

            <header class="pv-head">
                <div>
                    <p class="pv-kicker">Prenatal Visit</p>
                    <h1 class="pv-title">{{ $pvDate->format('F d, Y') }}</h1>
                    <p class="pv-subtitle">{{ $pvVisit->gestational_age_weeks }} weeks of gestation &middot; recorded visit details</p>
                </div>

                <div class="pv-head-actions">
                    <a href="{{ route('prenatal-checkups.edit', $pvVisit->id) }}" class="pv-btn pv-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                        </svg>
                        Edit Visit
                    </a>
                    <form action="{{ route('prenatal-checkups.destroy', $pvVisit->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this prenatal visit? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="pv-btn pv-btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            Delete Visit
                        </button>
                    </form>
                </div>
            </header>

            @if (session('success'))
                <div class="pv-alert pv-alert-success" role="status" aria-live="polite" style="margin: 0 0 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @include('prenatal-checkups._banner', ['mother' => $pvVisit->mother])

            {{-- ================= Visit summary ================= --}}
            <section class="pv-card" aria-labelledby="pv-summary-title">
                <div class="pv-card-head">
                    <div class="pv-card-head-main">
                        <span class="pv-step" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="pv-card-title" id="pv-summary-title">Visit Summary</h2>
                            <p class="pv-card-sub">Vital signs and fetal assessment recorded at this visit.</p>
                        </div>
                    </div>
                </div>

                <div class="pv-vitals">
                    @foreach ([
                        ['Gestational Age', $pvVisit->gestational_age_weeks, 'weeks', 'M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z'],
                        ['Blood Pressure', $pvVisit->systolic_bp . '/' . $pvVisit->diastolic_bp, 'mmHg', 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z'],
                        ['Weight', number_format($pvVisit->weight, 2), 'kg', 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z'],
                        ['Fundal Height', $pvVisit->fundal_height, 'cm', 'M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5'],
                        ['Fetal Heart Rate', $pvVisit->fetal_heart_rate, 'bpm', 'M3.75 13.5l3-3 3 3 4.5-6 3 3 3-3'],
                        ['Fetal Movement', $pvVisit->fetal_movement, null, 'M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z'],
                    ] as [$label, $value, $unit, $icon])
                        <div class="pv-vital">
                            <span class="pv-vital-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
                                </svg>
                            </span>
                            <div>
                                <p class="pv-vital-label">{{ $label }}</p>
                                <p class="pv-vital-value">
                                    @if (filled($value))
                                        {{ $value }}@if ($unit)<small>{{ $unit }}</small>@endif
                                    @else
                                        {!! $pvNotRecorded !!}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- ================= Laboratory findings ================= --}}
            <section class="pv-card" aria-labelledby="pv-labs-title">
                <div class="pv-card-head">
                    <div class="pv-card-head-main">
                        <span class="pv-step" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="pv-card-title" id="pv-labs-title">Laboratory Findings</h2>
                            <p class="pv-card-sub">Manually entered results and any attached laboratory reports.</p>
                        </div>
                    </div>
                </div>

                <div class="pv-labs">
                    @foreach (['Urine Protein' => $pvVisit->urine_protein, 'Urine Glucose' => $pvVisit->urine_glucose] as $label => $value)
                        <div class="pv-lab">
                            <p class="pv-vital-label">{{ $label }}</p>
                            <p class="pv-vital-value">
                                @if (filled($value)) {{ $value }} @else {!! $pvNotRecorded !!} @endif
                            </p>
                        </div>
                    @endforeach
                </div>

                <h3 class="pv-subhead">
                    Laboratory Documents
                    <span class="pv-optional">{{ $pvVisit->attachments->count() }} attached</span>
                </h3>

                @if ($pvVisit->attachments->isNotEmpty())
                    <div class="pv-docs">
                        @foreach ($pvVisit->attachments as $attachment)
                            @php
                                $pvExt = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                $pvIsImage = in_array($pvExt, ['jpg', 'jpeg', 'png'], true);
                            @endphp
                            <article class="pv-doc">
                                @if ($pvIsImage)
                                    <a href="{{ route('midwife.prenatal-attachments.preview', $attachment->id) }}" target="_blank" rel="noopener"
                                       class="pv-doc-thumb" aria-label="Open {{ $attachment->file_name }}">
                                        <img src="{{ route('midwife.prenatal-attachments.preview', $attachment->id) }}"
                                             alt="{{ $attachment->file_name }}" loading="lazy">
                                    </a>
                                @else
                                    <div class="pv-doc-thumb" aria-hidden="true">
                                        <span class="pv-doc-pdf">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z"/>
                                            </svg>
                                            {{ strtoupper($pvExt ?: 'file') }}
                                        </span>
                                    </div>
                                @endif

                                <div class="pv-doc-body">
                                    <p class="pv-doc-name">{{ $attachment->file_name }}</p>
                                    <p class="pv-doc-meta">{{ strtoupper($pvExt) }} &middot; {{ number_format($attachment->file_size / 1024, 1) }} KB</p>
                                </div>

                                <div class="pv-doc-actions">
                                    @if ($pvIsImage)
                                        <a href="{{ route('midwife.prenatal-attachments.preview', $attachment->id) }}" target="_blank" rel="noopener"
                                           class="pv-btn pv-btn-quiet pv-btn-sm" aria-label="View {{ $attachment->file_name }}">View</a>
                                    @endif
                                    <a href="{{ route('midwife.prenatal-attachments.download', $attachment->id) }}"
                                       class="pv-btn pv-btn-secondary pv-btn-sm" aria-label="Download {{ $attachment->file_name }}">Download</a>
                                    <form action="{{ route('midwife.prenatal-attachments.destroy', $attachment->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this laboratory document?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="pv-btn pv-btn-danger pv-btn-sm" aria-label="Delete {{ $attachment->file_name }}">Delete</button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="pv-empty">
                        <strong>No laboratory documents attached</strong>
                        <p>Reports can be attached from <a href="{{ route('prenatal-checkups.edit', $pvVisit->id) }}">Edit Visit</a>.</p>
                    </div>
                @endif
            </section>

            {{-- ================= Assessment & follow-up ================= --}}
            <section class="pv-card" aria-labelledby="pv-notes-title">
                <div class="pv-card-head">
                    <div class="pv-card-head-main">
                        <span class="pv-step" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="pv-card-title" id="pv-notes-title">Assessment &amp; Follow-up</h2>
                            <p class="pv-card-sub">Clinical observations and the next scheduled visit.</p>
                        </div>
                    </div>
                </div>

                <div class="pv-notes">
                    <div class="pv-note">
                        <p class="pv-vital-label">Maternal Condition</p>
                        <p class="pv-note-text">@if (filled($pvVisit->maternal_condition)){{ $pvVisit->maternal_condition }}@else{!! $pvNotRecorded !!}@endif</p>
                    </div>
                    <div class="pv-note">
                        <p class="pv-vital-label">Clinical Notes</p>
                        <p class="pv-note-text">@if (filled($pvVisit->notes)){{ $pvVisit->notes }}@else{!! $pvNotRecorded !!}@endif</p>
                    </div>
                </div>

                <div class="pv-next">
                    <span class="pv-vital-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="pv-vital-label">Next Visit</p>
                        <p class="pv-vital-value">
                            @if ($pvVisit->next_visit_date)
                                {{ \Carbon\Carbon::parse($pvVisit->next_visit_date)->format('F d, Y') }}
                            @else
                                <span class="pv-empty-value">Not scheduled</span>
                            @endif
                        </p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
