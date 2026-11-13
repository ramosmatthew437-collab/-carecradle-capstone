{{-- Validation summary for Infant Management forms. Optional $infErrorTitle. --}}
@if ($errors->any())
    <div class="inf-alert inf-alert-error" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0Z"/>
        </svg>
        <div>
            <p class="inf-alert-title">{{ $infErrorTitle ?? 'Please correct the following' }}</p>
            <ul>
                @foreach ($errors->all() as $infError)
                    <li>{{ $infError }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
