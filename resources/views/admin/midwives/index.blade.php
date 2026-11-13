<x-app-layout>

    {{-- Shared Administrator styles (admin-only, scoped to .adm-page; no rebuild needed) --}}
    @include('admin.partials.ui-styles')

    <div class="adm-page">

        <div class="adm-container">

            {{-- ========================================= --}}
            {{-- ALERTS (unchanged markup: the page script
                 dismisses them through the mm-alert classes) --}}
            {{-- ========================================= --}}



            @if(session('success'))

                <div class="mm-alert mm-alert-success" role="status" aria-live="polite">



                    <div class="mm-alert-icon">

                        <svg width="20" height="20" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <path d="M20 6L9 17l-5-5"/>

                        </svg>

                    </div>



                    <div class="mm-alert-content">

                        <p class="mm-alert-title">Success</p>

                        <p class="mm-alert-msg">{{ session('success') }}</p>

                    </div>



                    <button

                        type="button"

                        class="mm-alert-close"

                        aria-label="Dismiss success notification"

                    >

                        <svg width="16" height="16" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <path d="M18 6L6 18M6 6l12 12"/>

                        </svg>

                    </button>



                </div>

            @endif





            {{-- ========================================= --}}

            {{-- VALIDATION / ERROR ALERT --}}

            {{-- ========================================= --}}



            @if($errors->any())

                <div class="mm-alert mm-alert-error" role="alert" aria-live="assertive">



                    <div class="mm-alert-icon">

                        <svg width="20" height="20" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <circle cx="12" cy="12" r="9"/>

                            <path d="M12 8v4"/>

                            <path d="M12 16h.01"/>

                        </svg>

                    </div>



                    <div class="mm-alert-content">

                        <p class="mm-alert-title">Please Check Your Information</p>



                        @if($errors->count() === 1)

                            <p class="mm-alert-msg">

                                {{ $errors->first() }}

                            </p>

                        @else

                            <ul class="mm-alert-errors">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        @endif

                    </div>



                    <button

                        type="button"

                        class="mm-alert-close"

                        aria-label="Dismiss error notification"

                    >

                        <svg width="16" height="16" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <path d="M18 6L6 18M6 6l12 12"/>

                        </svg>

                    </button>



                </div>

            @endif


            {{-- ========================================= --}}
            {{-- PAGE HEADER --}}
            {{-- ========================================= --}}
            <section class="adm-page-header" aria-labelledby="mm-page-title">
                <div class="adm-page-header-main">
                    <div class="adm-page-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="adm-eyebrow">Healthcare Workforce</p>
                        <h1 class="adm-page-title" id="mm-page-title">Midwife Management</h1>
                        <p class="adm-page-desc">Manage registered midwives and their access to the CareCradle system.</p>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <a href="{{ route('dashboard') }}" class="adm-btn adm-btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>

                    <a href="{{ route('midwives.create') }}" class="adm-btn adm-btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        <span>Register Midwife</span>
                    </a>
                </div>
            </section>

            {{-- ========================================= --}}
            {{-- STATISTICS --}}
            {{-- ========================================= --}}
            <section class="adm-stats" aria-label="Midwife account summary">

                {{-- Total --}}
                <div class="adm-stat adm-tone-1">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $totalMidwives }}</p>
                        <p class="adm-stat-label">Registered healthcare staff</p>
                    </div>
                </div>

                {{-- Active --}}
                <div class="adm-stat adm-tone-3">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M8.5 12.5l2.5 2.5 4.5-5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $activeMidwives }}</p>
                        <p class="adm-stat-label">Currently providing services</p>
                    </div>
                </div>

                {{-- Inactive --}}
                <div class="adm-stat adm-tone-4">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M5.6 5.6l12.8 12.8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $inactiveMidwives }}</p>
                        <p class="adm-stat-label">Accounts currently disabled</p>
                    </div>
                </div>

            </section>

            {{-- ========================================= --}}
            {{-- SEARCH AND STATUS FILTER --}}
            {{-- ========================================= --}}
            <section class="adm-card">
                <form method="GET" action="{{ route('midwives.index') }}">
                    <div class="adm-toolbar">

                        <div class="adm-search">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-3.5-3.5"/>
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search username, name, contact number, email..."
                                aria-label="Search midwives"
                            >
                            <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">
                                Search
                            </button>
                        </div>

                        @php
                            $currentStatus = request('status', 'all');
                            $currentSearch = request('search', '');
                        @endphp

                        <nav class="adm-segment" aria-label="Filter midwives by status">
                            <a
                                href="{{ route('midwives.index', ['status' => 'all', 'search' => $currentSearch]) }}"
                                class="{{ $currentStatus === 'all' ? 'is-selected' : '' }}"
                                aria-current="{{ $currentStatus === 'all' ? 'page' : 'false' }}"
                            >
                                <span class="adm-dot adm-dot-all"></span>
                                All Midwives
                            </a>
                            <a
                                href="{{ route('midwives.index', ['status' => 'active', 'search' => $currentSearch]) }}"
                                class="{{ $currentStatus === 'active' ? 'is-selected' : '' }}"
                                aria-current="{{ $currentStatus === 'active' ? 'page' : 'false' }}"
                            >
                                <span class="adm-dot adm-dot-active"></span>
                                Active
                            </a>
                            <a
                                href="{{ route('midwives.index', ['status' => 'inactive', 'search' => $currentSearch]) }}"
                                class="{{ $currentStatus === 'inactive' ? 'is-selected' : '' }}"
                                aria-current="{{ $currentStatus === 'inactive' ? 'page' : 'false' }}"
                            >
                                <span class="adm-dot adm-dot-inactive"></span>
                                Inactive
                            </a>
                        </nav>

                        @if(request('search'))
                            <div class="adm-toolbar-foot">
                                <a href="{{ route('midwives.index') }}" class="adm-link">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                                        <path d="M3 3v5h5"/>
                                    </svg>
                                    Reset Search
                                </a>
                            </div>
                        @endif

                    </div>
                </form>
            </section>

            {{-- ========================================= --}}
            {{-- MIDWIFE LIST --}}
            {{-- ========================================= --}}
            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Registered Midwives</h2>
                            <p class="adm-card-sub">Manage healthcare professionals assigned to the Rural Health Unit.</p>
                        </div>
                    </div>

                    <span class="adm-count">
                        @if(request('search'))
                            {{ $midwives->count() }} of {{ $totalMidwives }} Records
                        @else
                            {{ $totalMidwives }} Records
                        @endif
                    </span>
                </div>

                @if($midwives->count())

                    {{-- One table for every screen size: rows become
                         labelled cards on phones (see ui-styles). --}}
                    <div class="adm-table-scroll">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>Contact Number</th>
                                    <th>Email Address</th>
                                    <th class="adm-center">Status</th>
                                    <th class="adm-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($midwives as $midwife)
                                    <tr>
                                        <td data-label="Username">
                                            <div>
                                                <p class="adm-strong">{{ $midwife->username }}</p>
                                                <p class="adm-subtext">System Account</p>
                                            </div>
                                        </td>

                                        <td data-label="Full Name">
                                            <div class="adm-person">
                                                <div class="adm-avatar" aria-hidden="true">
                                                    {{ strtoupper(
                                                        substr($midwife->first_name, 0, 1) .
                                                        substr($midwife->last_name, 0, 1)
                                                    ) }}
                                                </div>
                                                <div>
                                                    <p class="adm-strong">
                                                        {{ trim(
                                                            $midwife->first_name . ' ' .
                                                            $midwife->middle_name . ' ' .
                                                            $midwife->last_name
                                                        ) }}
                                                    </p>
                                                    <p class="adm-subtext">Registered Midwife</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td data-label="Contact Number" class="adm-muted">
                                            {{ $midwife->contact_number ?: '—' }}
                                        </td>

                                        <td data-label="Email Address" class="adm-muted">
                                            {{ $midwife->email ?: '—' }}
                                        </td>

                                        <td data-label="Status" class="adm-center">
                                            @if($midwife->is_active)
                                                <span class="adm-pill adm-pill-success">
                                                    <span class="adm-pill-dot"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span class="adm-pill adm-pill-muted">
                                                    <span class="adm-pill-dot"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td data-label="Actions" class="adm-center">
                                            <div class="adm-row-actions">

                                                {{-- Edit --}}
                                                <a
                                                    href="{{ route('midwives.edit', $midwife->id) }}"
                                                    aria-label="Edit {{ $midwife->username }}"
                                                    class="adm-btn adm-btn-sm adm-btn-edit"
                                                >
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                {{-- Deactivate / Activate (confirmed through the modal below) --}}
                                                @if($midwife->is_active)
                                                    <form
                                                        action="{{ route('midwives.destroy', $midwife->id) }}"
                                                        method="POST"
                                                        class="mm-status-form"
                                                        data-confirm-action="deactivate"
                                                        data-midwife-name="{{ trim($midwife->first_name . ' ' . $midwife->last_name) }}"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            aria-label="Deactivate {{ $midwife->username }}"
                                                            class="adm-btn adm-btn-sm adm-btn-danger"
                                                        >
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <circle cx="12" cy="12" r="9"/>
                                                                <path d="M5.6 5.6l12.8 12.8"/>
                                                            </svg>
                                                            <span>Deactivate</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ route('midwives.activate', $midwife->id) }}"
                                                        method="POST"
                                                        class="mm-status-form"
                                                        data-confirm-action="activate"
                                                        data-midwife-name="{{ trim($midwife->first_name . ' ' . $midwife->last_name) }}"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            aria-label="Activate {{ $midwife->username }}"
                                                            class="adm-btn adm-btn-sm adm-btn-success"
                                                        >
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M20 6L9 17l-5-5"/>
                                                            </svg>
                                                            <span>Activate</span>
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                    {{-- ========================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ========================================= --}}
                    <div class="adm-empty">
                        <div class="adm-empty-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>

                        <p class="adm-empty-title">
                            @if(request('search'))
                                No Midwives Found
                            @else
                                No Registered Midwives
                            @endif
                        </p>

                        <p class="adm-empty-desc">
                            @if(request('search'))
                                No midwife accounts match your search.
                                Try using a different name, username, contact number, or email.
                            @else
                                There are currently no registered midwives in the CareCradle system.
                                Add a healthcare provider to begin managing midwife accounts for the Rural Health Unit.
                            @endif
                        </p>

                        @if(request('search'))
                            <a href="{{ route('midwives.index') }}" class="adm-btn adm-btn-secondary">
                                Clear Search
                            </a>
                        @else
                            <a href="{{ route('midwives.create') }}" class="adm-btn adm-btn-primary">
                                Register Midwife
                            </a>
                        @endif
                    </div>

                @endif

            </section>

        </div>

    </div>


    {{-- ========================================= --}}

    {{-- CONFIRMATION MODAL --}}

    {{-- ========================================= --}}



    <div

        id="mm-confirm-modal"

        class="mm-modal"

        aria-hidden="true"

        role="dialog"

        aria-modal="true"

        aria-labelledby="mm-modal-title"

        aria-describedby="mm-modal-description"

    >

        <div class="mm-modal-backdrop" data-modal-close></div>



        <div class="mm-modal-dialog" role="document">



            <div class="mm-modal-icon mm-modal-icon-deactivate" id="mm-modal-icon">

                <svg

                    id="mm-modal-icon-deactivate"

                    width="24"

                    height="24"

                    viewBox="0 0 24 24"

                    fill="none"

                    stroke="currentColor"

                    stroke-width="1.8"

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    aria-hidden="true"

                >

                    <path d="M18.364 18.364A9 9 0 005.636 5.636"/>

                    <path d="M5.636 18.364A9 9 0 0018.364 5.636"/>

                    <path d="M18.364 18.364L5.636 5.636"/>

                </svg>



                <svg

                    id="mm-modal-icon-activate"

                    width="24"

                    height="24"

                    viewBox="0 0 24 24"

                    fill="none"

                    stroke="currentColor"

                    stroke-width="2"

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    aria-hidden="true"

                >

                    <path d="M20 6L9 17l-5-5"/>

                </svg>

            </div>





            <div class="mm-modal-content">



                <h2 id="mm-modal-title" class="mm-modal-title">

                    Confirm Action

                </h2>



                <p id="mm-modal-description" class="mm-modal-description">

                    Are you sure you want to continue?

                </p>



                <div class="mm-modal-account" id="mm-modal-account">

                    <span class="mm-modal-account-label">Midwife Account</span>

                    <strong id="mm-modal-midwife-name"></strong>

                </div>



            </div>





            <div class="mm-modal-actions">



                <button

                    type="button"

                    class="mm-modal-button mm-modal-cancel"

                    id="mm-modal-cancel"

                >

                    Cancel

                </button>



                <button

                    type="button"

                    class="mm-modal-button mm-modal-confirm"

                    id="mm-modal-confirm"

                >

                    <span class="mm-modal-confirm-spinner" aria-hidden="true"></span>

                    <span id="mm-modal-confirm-text">Confirm</span>

                </button>



            </div>



        </div>

    </div>





    {{-- ========================================= --}}

    {{-- INTERACTION JAVASCRIPT --}}

    {{-- ========================================= --}}



    <script>

        document.addEventListener('DOMContentLoaded', function () {



            const modal = document.getElementById('mm-confirm-modal');

            const modalTitle = document.getElementById('mm-modal-title');

            const modalDescription = document.getElementById('mm-modal-description');

            const modalName = document.getElementById('mm-modal-midwife-name');

            const modalIcon = document.getElementById('mm-modal-icon');



            const deactivateIcon = document.getElementById('mm-modal-icon-deactivate');

            const activateIcon = document.getElementById('mm-modal-icon-activate');



            const cancelButton = document.getElementById('mm-modal-cancel');

            const confirmButton = document.getElementById('mm-modal-confirm');

            const confirmText = document.getElementById('mm-modal-confirm-text');



            let activeForm = null;

            let activeAction = null;

            let lastFocusedElement = null;



            function openModal(form) {



                activeForm = form;

                activeAction = form.dataset.confirmAction || 'deactivate';



                lastFocusedElement = document.activeElement;



                const midwifeName = form.dataset.midwifeName || 'this midwife';



                if (activeAction === 'activate') {



                    modalTitle.textContent = 'Activate Midwife Account?';



                    modalDescription.textContent =

                        'Are you sure you want to activate this midwife account? The midwife will regain access to the CareCradle system.';



                    confirmText.textContent = 'Activate Account';



                    modalIcon.classList.remove('mm-modal-icon-deactivate');

                    modalIcon.classList.add('mm-modal-icon-activate');



                    deactivateIcon.style.display = 'none';

                    activateIcon.style.display = 'block';



                    confirmButton.classList.remove('mm-modal-confirm-deactivate');

                    confirmButton.classList.add('mm-modal-confirm-activate');



                } else {



                    modalTitle.textContent = 'Deactivate Midwife Account?';



                    modalDescription.textContent =

                        'Are you sure you want to deactivate this midwife account? The account will no longer be able to access the CareCradle system until it is activated again.';



                    confirmText.textContent = 'Deactivate Account';



                    modalIcon.classList.remove('mm-modal-icon-activate');

                    modalIcon.classList.add('mm-modal-icon-deactivate');



                    deactivateIcon.style.display = 'block';

                    activateIcon.style.display = 'none';



                    confirmButton.classList.remove('mm-modal-confirm-activate');

                    confirmButton.classList.add('mm-modal-confirm-deactivate');



                }



                modalName.textContent = midwifeName;



                modal.classList.add('is-open');

                modal.setAttribute('aria-hidden', 'false');



                document.body.classList.add('mm-modal-open');



                window.setTimeout(function () {

                    cancelButton.focus();

                }, 50);

            }





            function closeModal() {



                if (!modal.classList.contains('is-open')) {

                    return;

                }



                modal.classList.remove('is-open');

                modal.setAttribute('aria-hidden', 'true');



                document.body.classList.remove('mm-modal-open');



                activeForm = null;

                activeAction = null;



                if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {

                    lastFocusedElement.focus();

                }



                lastFocusedElement = null;

            }





            document.querySelectorAll('.mm-status-form').forEach(function (form) {



                form.addEventListener('submit', function (event) {



                    if (form.dataset.confirmed === 'true') {

                        return;

                    }



                    event.preventDefault();



                    openModal(form);

                });



            });





            confirmButton.addEventListener('click', function () {



                if (!activeForm || confirmButton.disabled) {

                    return;

                }



                activeForm.dataset.confirmed = 'true';



                confirmButton.disabled = true;

                cancelButton.disabled = true;



                confirmButton.classList.add('is-loading');



                if (activeAction === 'activate') {

                    confirmText.textContent = 'Activating...';

                } else {

                    confirmText.textContent = 'Deactivating...';

                }



                activeForm.submit();

            });





            cancelButton.addEventListener('click', function () {

                closeModal();

            });





            modal.querySelectorAll('[data-modal-close]').forEach(function (element) {



                element.addEventListener('click', function () {

                    closeModal();

                });



            });





            document.addEventListener('keydown', function (event) {



                if (!modal.classList.contains('is-open')) {

                    return;

                }



                if (event.key === 'Escape') {

                    event.preventDefault();

                    closeModal();

                    return;

                }



                if (event.key === 'Tab') {



                    const focusableElements = modal.querySelectorAll(

                        'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled])'

                    );



                    if (!focusableElements.length) {

                        return;

                    }



                    const firstElement = focusableElements[0];

                    const lastElement = focusableElements[focusableElements.length - 1];



                    if (event.shiftKey && document.activeElement === firstElement) {

                        event.preventDefault();

                        lastElement.focus();

                    } else if (!event.shiftKey && document.activeElement === lastElement) {

                        event.preventDefault();

                        firstElement.focus();

                    }

                }



            });





            document.querySelectorAll('.mm-alert-close').forEach(function (button) {



                button.addEventListener('click', function () {



                    const alert = button.closest('.mm-alert');



                    if (alert) {

                        alert.classList.add('mm-alert-dismissed');



                        window.setTimeout(function () {

                            alert.remove();

                        }, 180);

                    }



                });



            });





            const successAlert = document.querySelector('.mm-alert-success');



            if (successAlert) {



                window.setTimeout(function () {



                    if (!successAlert.classList.contains('mm-alert-dismissed')) {



                        successAlert.classList.add('mm-alert-dismissed');



                        window.setTimeout(function () {

                            successAlert.remove();

                        }, 180);



                    }



                }, 6000);



            }



        });

    </script>


</x-app-layout>
