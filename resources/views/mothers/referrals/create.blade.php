<x-app-layout>
    @include('mothers.referrals._styles')

    <div class="mrf mrf-page">
        <div class="mrf-container">
            <a href="{{ route('mothers.show', $mother->id) }}#referral" class="mrf-back">← Back to mother profile</a>

            <p class="mrf-kicker">Mother Management · {{ $mother->mother_code }}</p>
            <h1 class="mrf-title">Record Referral</h1>
            <p class="mrf-sub">
                {{ trim($mother->first_name . ' ' . $mother->last_name) }} · Pregnancy status: <strong>{{ $mother->pregnancyStatusLabel() }}</strong>.
                Recording a referral does not change her pregnancy status, account, records, appointments or SMS reminders.
            </p>

            @if ($errors->any())
                <div class="mrf-alert mrf-alert-error" role="alert"><div><strong>Please correct the following</strong><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div></div>
            @endif

            <form method="POST" action="{{ route('referrals.store', $mother->id) }}" class="mrf-card">
                @csrf
                @include('mothers.referrals._fields', ['referral' => null])
                <div class="mrf-actions">
                    <button type="submit" class="mrf-btn mrf-btn-primary">Save referral</button>
                    <a href="{{ route('mothers.show', $mother->id) }}#referral" class="mrf-btn mrf-btn-quiet">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
