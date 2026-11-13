{{-- Referral detail fields. Expects $referral (or null). --}}
<div class="mrf-grid">
    <div class="mrf-field">
        <label class="mrf-label" for="mrf-referred-at">Referral date <span class="mrf-req">*</span></label>
        <input id="mrf-referred-at" type="date" name="referred_at" class="mrf-input" max="{{ today()->toDateString() }}" required
            value="{{ old('referred_at', $referral?->referred_at?->toDateString()) }}">
        @error('referred_at')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
    <div class="mrf-field">
        <label class="mrf-label" for="mrf-facility">Receiving facility <span class="mrf-req">*</span></label>
        <input id="mrf-facility" type="text" name="receiving_facility" class="mrf-input" maxlength="255" required
            value="{{ old('receiving_facility', $referral?->receiving_facility) }}" placeholder="e.g. Provincial hospital">
        @error('receiving_facility')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
    <div class="mrf-field mrf-full">
        <label class="mrf-label" for="mrf-reason">Reason for referral <span class="mrf-req">*</span></label>
        <textarea id="mrf-reason" name="reason" class="mrf-textarea" maxlength="1000" required>{{ old('reason', $referral?->reason) }}</textarea>
        @error('reason')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
    <div class="mrf-field mrf-full">
        <label class="mrf-label" for="mrf-notes">Notes</label>
        <textarea id="mrf-notes" name="notes" class="mrf-textarea" maxlength="2000">{{ old('notes', $referral?->notes) }}</textarea>
        @error('notes')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
</div>
<p class="mrf-hint" style="margin-top:0.75rem">The referring health worker is recorded automatically as the signed-in staff member.</p>
