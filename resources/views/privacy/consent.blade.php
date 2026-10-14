<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Privacy Notice & Consent - CareCradle</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/css/carecradle.css'
    ])
</head>

<body class="cc-privacy-page">

    <main class="cc-privacy-wrapper">

        <div class="cc-privacy-card">

            {{-- =========================================================
                 HEADER
            ========================================================== --}}
            <div class="cc-privacy-header">

                <div class="cc-privacy-logo">
                    <img
                        src="{{ asset('images/system.logo.png') }}"
                        alt="CareCradle"
                    >
                </div>

                <div>
                    <p class="cc-privacy-eyebrow">
                        CARECRADLE
                    </p>

                    <h1 class="cc-privacy-title">
                        Privacy Notice & Consent
                    </h1>

                    <p class="cc-privacy-subtitle">
                        Your privacy matters to us.
                    </p>
                </div>

            </div>


            {{-- =========================================================
                 PRIVACY NOTICE CONTENT
            ========================================================== --}}
            <div class="cc-privacy-content">

                {{-- Introduction --}}
                <section class="cc-privacy-intro">

                    <h2>Your Privacy Matters</h2>

                    <p>
                        CareCradle respects your privacy and is committed to
                        protecting your personal information in accordance with
                        Republic Act No. 10173, or the Data Privacy Act of 2012.
                    </p>

                    <p>
                        Before using CareCradle, please read and understand how
                        your information will be collected and processed.
                    </p>

                </section>


                {{-- Information We Collect --}}
                <section class="cc-privacy-section">

                    <h2>Information We Collect</h2>

                    <p>
                        CareCradle may collect and store information such as:
                    </p>

                    <ul>
                        <li>Mother's name and basic personal information</li>
                        <li>Contact information</li>
                        <li>Pregnancy and prenatal care records</li>
                        <li>Appointment information</li>
                        <li>
                            Infant's name, birth information, and health records
                        </li>
                        <li>Infant growth and vaccination records</li>
                        <li>
                            Other information necessary for maternal and infant
                            health monitoring
                        </li>
                    </ul>

                </section>


                {{-- Purpose of Collection --}}
                <section class="cc-privacy-section">

                    <h2>Purpose of Collection</h2>

                    <ul>
                        <li>
                            Maintain and organize digital Mother and Child Book
                            records
                        </li>

                        <li>
                            Monitor pregnancy and infant growth
                        </li>

                        <li>
                            Manage prenatal and infant health appointments
                        </li>

                        <li>
                            Provide health-related reminders through SMS
                        </li>

                        <li>
                            Help authorized health workers manage maternal and
                            infant records
                        </li>

                        <li>
                            Generate reports necessary for operation and
                            evaluation
                        </li>
                    </ul>

                </section>


                {{-- Data Protection --}}
                <section class="cc-privacy-section">

                    <h2>Data Protection</h2>

                    <p>
                        Personal information will only be accessed by authorized
                        users for legitimate CareCradle purposes. Reasonable
                        security measures are implemented to help protect
                        personal information against unauthorized access,
                        alteration, disclosure, or loss.
                    </p>

                </section>


                {{-- Your Rights --}}
                <section class="cc-privacy-section">

                    <h2>Your Rights</h2>

                    <p>
                        Under the Data Privacy Act of 2012, you have rights
                        regarding your personal information, including the
                        right to be informed and the right to access and
                        request correction of your information, subject to
                        applicable laws and system policies.
                    </p>

                </section>


                {{-- =========================================================
                     CONSENT
                ========================================================== --}}
                <section class="cc-privacy-consent-box">

                    {{-- Consent Heading --}}
                    <div class="cc-privacy-consent-heading">

                        <span class="cc-privacy-consent-icon">
                            ✓
                        </span>

                        <div>
                            <h2>Consent</h2>

                            <p>
                                Please confirm that you have read and understood
                                this Privacy Notice before continuing.
                            </p>
                        </div>

                    </div>


                    {{-- =====================================================
                         ACCEPT FORM
                    ====================================================== --}}
                    <form
                        method="POST"
                        action="{{ route('privacy.consent.accept') }}"
                    >

                        @csrf


                        {{-- Consent Checkbox --}}
                        <label class="cc-privacy-checkbox">

                            <input
                                type="checkbox"
                                name="privacy_consent"
                                value="1"
                                required
                                class="cc-privacy-checkbox-input"
                            >

                            <span class="cc-privacy-checkmark"></span>

                            <span class="cc-privacy-checkbox-text">
                                I have read and understood the Privacy Notice
                                and agree to the collection and processing of my
                                personal information in accordance with Republic
                                Act No. 10173, or the Data Privacy Act of 2012.
                            </span>

                        </label>


                        {{-- Validation Error --}}
                        @error('privacy_consent')

                            <p class="cc-privacy-error">
                                {{ $message }}
                            </p>

                        @enderror


                        {{-- =================================================
                             ACTION BUTTONS
                        ================================================== --}}
                        <div class="cc-privacy-actions">

                            {{-- Cancel --}}
                            <button
                                type="button"
                                class="cc-privacy-cancel"
                                onclick="document.getElementById('privacy-cancel-form').submit();"
                            >
                                Cancel
                            </button>


                            {{-- Agree --}}
                            <button
                                type="submit"
                                class="cc-privacy-agree"
                            >
                                <span>
                                    I Agree & Continue
                                </span>

                                <span aria-hidden="true">
                                    →
                                </span>
                            </button>

                        </div>

                    </form>


                    {{-- =====================================================
                         CANCEL FORM
                    ====================================================== --}}
                    <form
                        id="privacy-cancel-form"
                        method="POST"
                        action="{{ route('privacy.consent.cancel') }}"
                        style="display: none;"
                    >

                        @csrf

                    </form>

                </section>

            </div>


            {{-- =========================================================
                 FOOTER
            ========================================================== --}}
            <div class="cc-privacy-footer">

                <span>CareCradle</span>

                <span>•</span>

                <span>
                    Data Privacy Act of 2012
                </span>

            </div>

        </div>

    </main>

</body>
</html>