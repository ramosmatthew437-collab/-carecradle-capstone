<x-app-layout>
    @include('mothers.referrals._styles')

    <div class="mrf mrf-page">
        <div class="mrf-container">
            <a href="{{ route('mothers.show', $mother->id) }}#referral" class="mrf-back">← Back to mother profile</a>

            <p class="mrf-kicker">Mother Management · {{ $mother->mother_code }} · Referral #{{ $referral->id }}</p>
            <h1 class="mrf-title">Update Referral</h1>
            <p class="mrf-sub">
                Referred by {{ $referral->referred_by_name ?? 'unknown' }}. Changes are recorded in the Activity Log.
                Pregnancy status, records, appointments and reminders are not changed here.
            </p>

            @if ($errors->any())
                <div class="mrf-alert mrf-alert-error" role="alert"><div><strong>Please correct the following</strong><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div></div>
            @endif

            <form method="POST" action="{{ route('referrals.update', $referral->id) }}" class="mrf-card">
                @csrf
                @method('PUT')
                <h2 class="mrf-card-title">Referral details</h2>
                @include('mothers.referrals._fields', ['referral' => $referral])
                <div class="mrf-actions">
                    <button type="submit" class="mrf-btn mrf-btn-primary">Save changes</button>
                </div>
            </form>

            <form method="POST" action="{{ route('referrals.close', $referral->id) }}" class="mrf-card">
                @csrf
                <h2 class="mrf-card-title">Record follow-up and close</h2>
                <p class="mrf-hint" style="margin:-0.25rem 0 0.875rem">Use this when the referral is finished. Information received from another facility should name that facility as the source.</p>
                <div class="mrf-grid">
                    <div class="mrf-field">
                        <label class="mrf-label" for="mrf-outcome-at">Follow-up date <span class="mrf-req">*</span></label>
                        <input id="mrf-outcome-at" type="date" name="outcome_at" class="mrf-input" min="{{ $referral->referred_at->toDateString() }}" max="{{ today()->toDateString() }}" value="{{ old('outcome_at') }}" required>
                        @error('outcome_at')<p class="mrf-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="mrf-field">
                        <label class="mrf-label" for="mrf-source">Information source</label>
                        <input id="mrf-source" type="text" name="outcome_source" class="mrf-input" maxlength="255" value="{{ old('outcome_source') }}" placeholder="e.g. receiving facility, or RHU follow-up">
                        @error('outcome_source')<p class="mrf-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="mrf-field mrf-full">
                        <label class="mrf-label" for="mrf-outcome">Follow-up / outcome notes <span class="mrf-req">*</span></label>
                        <textarea id="mrf-outcome" name="outcome_notes" class="mrf-textarea" maxlength="2000" required>{{ old('outcome_notes') }}</textarea>
                        @error('outcome_notes')<p class="mrf-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mrf-actions">
                    <button type="submit" class="mrf-btn mrf-btn-secondary" onclick="return confirm('Record this follow-up and close the referral?')">Record follow-up and close</button>
                </div>
            </form>

            <div class="mrf-card">
                <details @if ($errors->has('voided_reason')) open @endif>
                    <summary>Recorded by mistake?</summary>
                    <form method="POST" action="{{ route('referrals.void', $referral->id) }}" style="margin-top:0.75rem">
                        @csrf
                        <div class="mrf-field">
                            <label class="mrf-label" for="mrf-void">Why was this referral entered in error? <span class="mrf-req">*</span></label>
                            <textarea id="mrf-void" name="voided_reason" class="mrf-textarea" maxlength="500" required>{{ old('voided_reason') }}</textarea>
                            @error('voided_reason')<p class="mrf-error">{{ $message }}</p>@enderror
                        </div>
                        <p class="mrf-hint" style="margin-top:0.5rem">The referral is not deleted; it stays in her history marked “Entered in error”.</p>
                        <div class="mrf-actions">
                            <button type="submit" class="mrf-btn mrf-btn-danger" onclick="return confirm('Mark this referral as entered in error?')">Mark as entered in error</button>
                        </div>
                    </form>
                </details>
            </div>
        </div>
    </div>
</x-app-layout>
