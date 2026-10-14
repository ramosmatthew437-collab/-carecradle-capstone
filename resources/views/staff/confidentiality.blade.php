
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Confidentiality | CareCradle</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink: #ec4899;
            --dark-pink: #be185d;
            --deep-rose: #9d174d;
            --soft-pink: #fdf2f8;
            --border-pink: #fbcfe8;
            --text: #374151;
            --muted: #6b7280;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 32px 16px;
            background:
                radial-gradient(circle at top left, #fce7f3 0, transparent 35%),
                linear-gradient(135deg, #fff8fa, #fdf2f8);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        .container {
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-name {
            color: var(--dark-pink);
            font-family: 'DM Serif Display', serif;
            font-size: 32px;
            margin: 0;
        }

        .brand-subtitle {
            color: var(--muted);
            font-size: 13px;
            margin-top: 6px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border-pink);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(157, 23, 77, 0.08);
        }

        .hero {
            padding: 32px;
            background: linear-gradient(135deg, #fce7f3, #fff1f7);
            border-bottom: 1px solid var(--border-pink);
        }

        .eyebrow {
            display: inline-block;
            padding: 7px 12px;
            background: white;
            border: 1px solid var(--border-pink);
            border-radius: 999px;
            color: var(--dark-pink);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        h1 {
            margin: 18px 0 10px;
            color: var(--deep-rose);
            font-family: 'DM Serif Display', serif;
            font-size: clamp(29px, 5vw, 42px);
            font-weight: 400;
            line-height: 1.15;
        }

        .hero p {
            max-width: 650px;
            margin: 0;
            color: #6b4356;
            font-size: 14px;
            line-height: 1.8;
        }

        .content {
            padding: 30px 32px;
        }

        .notice {
            padding: 16px;
            margin-bottom: 24px;
            border: 1px solid var(--border-pink);
            border-radius: 14px;
            background: var(--soft-pink);
            font-size: 13px;
            line-height: 1.7;
        }

        .notice strong {
            color: var(--dark-pink);
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            margin: 0 0 9px;
            color: var(--deep-rose);
            font-size: 16px;
            font-weight: 700;
        }

        .section p,
        .section li {
            color: #596170;
            font-size: 13px;
            line-height: 1.85;
        }

        .section p {
            margin: 0;
        }

        .section ul {
            padding-left: 20px;
            margin: 8px 0 0;
        }

        .section li {
            padding-left: 4px;
            margin-bottom: 6px;
        }

        .acknowledgment {
            padding: 20px;
            margin-top: 28px;
            border: 1px solid var(--border-pink);
            border-radius: 15px;
            background: #fffafd;
        }

        .check-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            font-size: 13px;
            line-height: 1.8;
        }

        .check-row input {
            width: 18px;
            height: 18px;
            margin-top: 3px;
            flex-shrink: 0;
            accent-color: var(--pink);
        }

        .check-row strong {
            color: var(--deep-rose);
        }

        .error {
            margin-top: 12px;
            color: #be123c;
            font-size: 12px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 22px;
        }

        .submit-button {
            border: none;
            border-radius: 12px;
            padding: 14px 22px;
            background: linear-gradient(135deg, var(--pink), var(--dark-pink));
            color: white;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
        }

        .submit-button:hover {
            transform: translateY(-1px);
        }

        .submit-button:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }

        .footer {
            padding: 18px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .hero,
            .content {
                padding: 23px 19px;
            }

            .brand-name {
                font-size: 29px;
            }

            .actions {
                justify-content: stretch;
            }

            .submit-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <header class="brand">
            <p class="brand-name">CareCradle</p>
            <p class="brand-subtitle">Maternal and Infant Health Monitoring System</p>
        </header>

        <article class="card">
            <section class="hero">
                <span class="eyebrow">Staff Confidentiality</span>

                <h1>Protecting Every Mother's Privacy</h1>

                <p>
                    As an authorized CareCradle staff member, you may access
                    confidential maternal and infant health information.
                    Please review the following responsibilities before
                    entering the system.
                </p>
            </section>

            <div class="content">
                <div class="notice">
                    <strong>Important:</strong>
                    Access to patient information is permitted only for
                    legitimate, authorized healthcare and administrative
                    responsibilities. Acknowledging this policy does not
                    replace applicable laws, institutional rules, or
                    required authorization.
                </div>

                <section class="section">
                    <h2>1. Confidentiality of Patient Information</h2>
                    <p>
                        Maternal records, infant records, contact details,
                        medical histories, appointments, and other personal
                        information must be treated as confidential.
                        Information must not be disclosed to unauthorized
                        individuals.
                    </p>
                </section>

                <section class="section">
                    <h2>2. Authorized Access Only</h2>
                    <p>
                        Access patient records only when necessary for your
                        assigned duties. Do not browse, retrieve, download,
                        or share records for personal reasons or other
                        unauthorized purposes.
                    </p>
                </section>

                <section class="section">
                    <h2>3. Account Security</h2>
                    <ul>
                        <li>Keep your password and login credentials private.</li>
                        <li>Do not allow another person to use your account.</li>
                        <li>Log out when leaving a shared or unattended device.</li>
                        <li>Report suspected unauthorized access or account misuse.</li>
                    </ul>
                </section>

                <section class="section">
                    <h2>4. Proper Handling of Records</h2>
                    <p>
                        Do not make unauthorized copies, screenshots, exports,
                        or disclosures of patient information. Handle records
                        according to applicable data protection requirements
                        and the policies of the Irosin Rural Health Unit.
                    </p>
                </section>

                <section class="section">
                    <h2>5. Reporting Security Incidents</h2>
                    <p>
                        Promptly report suspected data breaches, lost devices,
                        exposed credentials, or unauthorized access to the
                        designated supervisor or authorized system administrator.
                    </p>
                </section>

                <section class="section">
                    <h2>6. Accountability</h2>
                    <p>
                        I understand that access to CareCradle is subject to
                        role-based permissions and applicable institutional
                        policies. Failure to follow confidentiality and
                        security requirements may result in appropriate
                        administrative action under applicable rules.
                    </p>
                </section>

                <div class="acknowledgment">
                    <form method="POST"
                          action="{{ route('staff.confidentiality.accept') }}">
                        @csrf

                        <label class="check-row">
                            <input
                                type="checkbox"
                                name="acknowledged"
                                value="1"
                                id="acknowledged"
                                required
                            >

                            <span>
                                <strong>I acknowledge and agree.</strong>
                                I have read and understood the CareCradle
                                Staff Confidentiality Policy. I agree to
                                protect confidential information and use
                                the system only for authorized duties.
                            </span>
                        </label>

                        @error('acknowledged')
                            <p class="error">{{ $message }}</p>
                        @enderror

                        <div class="actions">
                            <button
                                type="submit"
                                class="submit-button"
                                id="submitButton"
                                disabled
                            >
                                Acknowledge &amp; Continue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </article>

        <footer class="footer">
            CareCradle · Irosin Rural Health Unit · Staff Policy Version 1.0
        </footer>
    </main>

    <script>
        const checkbox = document.getElementById('acknowledged');
        const submitButton = document.getElementById('submitButton');

        checkbox.addEventListener('change', function () {
            submitButton.disabled = !this.checked;
        });
    </script>
</body>
</html>