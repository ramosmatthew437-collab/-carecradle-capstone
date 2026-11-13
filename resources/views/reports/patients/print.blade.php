<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Mother and Infant Health Record — {{ $mother->mother_code }} — CareCradle</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ---------- Page setup: margins, page numbers, footer ---------- */
        @page {
            size: A4 portrait;
            margin: 14mm 12mm 18mm;

            @bottom-left {
                content: "CareCradle · Irosin Rural Health Unit · Mother Code {{ $mother->mother_code }} · Printed {{ $printedAt->format('M d, Y') }}";
                font-family: "Inter", Arial, sans-serif;
                font-size: 7.5pt;
                color: #666666;
            }

            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
                font-family: "Inter", Arial, sans-serif;
                font-size: 7.5pt;
                color: #666666;
            }
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            background: #f4eef1;
            color: #111111;
            font-family: "Inter", Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }

        /* ---------- On-screen toolbar (never printed) ---------- */
        .print-toolbar {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 20px;
            background: #ffffff;
            border-bottom: 1px solid #f6d9e7;
            box-shadow: 0 4px 14px rgba(131, 24, 67, 0.08);
        }

        .print-toolbar p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }

        .print-toolbar strong {
            color: #4a0d2a;
        }

        .print-toolbar-actions {
            display: flex;
            gap: 8px;
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            font: 600 13px "Inter", Arial, sans-serif;
            text-decoration: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .print-btn-primary {
            color: #ffffff;
            background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
            border: 0;
        }

        .print-btn-secondary {
            color: #475569;
            background: #ffffff;
            border: 1px solid #e8dbe2;
        }

        /* ---------- Document sheet ---------- */
        .doc {
            width: 100%;
            max-width: 210mm;
            margin: 20px auto 40px;
            padding: 16mm 14mm;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(131, 24, 67, 0.10);
            /* Own stacking context so the watermark sits above the white
               sheet but below every line of text and table. */
            position: relative;
            isolation: isolate;
        }

        /* Official RHU watermark: very faint, centred, original proportions.
           On screen it sits once on the sheet; when printed it is fixed, so
           the browser repeats it on every page. */
        .doc-watermark {
            position: absolute;
            top: 70mm;
            left: 50%;
            z-index: -1;
            width: 110mm;
            transform: translateX(-50%);
            pointer-events: none;
        }

        .doc-watermark img {
            display: block;
            width: 100%;
            height: auto;
            opacity: 0.04;
        }

        .doc-letterhead {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #9d174d;
        }

        .doc-letterhead td {
            padding: 0 0 8px;
            vertical-align: middle;
        }

        .doc-letterhead-logo {
            width: 64px;
        }

        .doc-letterhead-logo img {
            width: 58px;
            height: 58px;
            border-radius: 50%;
        }

        /* Official RHU logo: right-aligned, original 1228x1281 proportions
           (height follows the width), no rounding or recolouring. */
        .doc-letterhead-logo-rhu {
            text-align: right;
        }

        .doc-letterhead-logo img.doc-rhu-logo {
            width: 56px;
            height: auto;
            border-radius: 0;
        }

        .doc-letterhead-text {
            text-align: center;
        }

        .doc-municipality {
            font-size: 10pt;
            letter-spacing: 0.04em;
        }

        .doc-office {
            font-size: 14pt;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .doc-system {
            color: #555555;
            font-size: 8.5pt;
        }

        .doc-title {
            margin: 12px 0 0;
            color: #4a0d2a;
            font-family: "DM Serif Display", Georgia, serif;
            font-size: 19pt;
            font-weight: 400;
            text-align: center;
        }

        .doc-subtitle {
            margin: 2px 0 12px;
            color: #555555;
            font-size: 8.5pt;
            text-align: center;
        }

        .doc-id,
        .doc-kv,
        .doc-table,
        .doc-signatures {
            width: 100%;
            border-collapse: collapse;
        }

        .doc-id {
            margin-bottom: 6px;
        }

        .doc-id th,
        .doc-id td,
        .doc-kv th,
        .doc-kv td {
            padding: 5px 7px;
            font-size: 9pt;
            text-align: left;
            vertical-align: top;
            border: 1px solid #d9d9d9;
        }

        .doc-id th,
        .doc-kv th {
            width: 19%;
            color: #444444;
            font-weight: 600;
            background: #fbf3f7;
        }

        .doc-id td {
            font-weight: 600;
        }

        .doc-kv {
            margin-top: 8px;
        }

        .doc-kv .doc-kv-group {
            color: #9d174d;
            font-size: 9pt;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: #f3e1ea;
        }

        .doc-h2 {
            margin: 16px 0 6px;
            padding-bottom: 3px;
            color: #4a0d2a;
            font-family: "DM Serif Display", Georgia, serif;
            font-size: 13.5pt;
            font-weight: 400;
            border-bottom: 1px solid #e7c6d6;
            break-after: avoid;
            page-break-after: avoid;
        }

        .doc-h3 {
            margin: 12px 0 4px;
            color: #4a0d2a;
            font-family: "DM Serif Display", Georgia, serif;
            font-size: 12pt;
            font-weight: 400;
            break-after: avoid;
            page-break-after: avoid;
        }

        .doc-h3-meta {
            color: #666666;
            font-family: "Inter", Arial, sans-serif;
            font-size: 8.5pt;
        }

        .doc-h4 {
            margin: 10px 0 4px;
            color: #9d174d;
            font-size: 9pt;
            font-weight: 700;
            break-after: avoid;
            page-break-after: avoid;
        }

        .doc-table thead {
            display: table-header-group;
        }

        .doc-table th {
            padding: 5px 6px;
            color: #111111;
            font-size: 8pt;
            font-weight: 700;
            text-align: left;
            background: #f3e1ea;
            border: 1px solid #d0b3c1;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .doc-table td {
            padding: 4px 6px;
            font-size: 8.5pt;
            vertical-align: top;
            border: 1px solid #dddddd;
        }

        .doc-keep {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .doc-detail-row td {
            color: #333333;
            font-size: 8pt;
            background: #fcf9fb;
        }

        .doc-empty,
        .doc-note {
            margin: 4px 0;
            color: #555555;
            font-size: 8.5pt;
        }

        .doc-note {
            font-style: italic;
        }

        .doc-infant {
            margin-bottom: 6px;
        }

        .doc-signatures {
            margin-top: 34px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .doc-signatures td {
            width: 45%;
            vertical-align: bottom;
        }

        .doc-signatures .doc-sign-gap {
            width: 10%;
        }

        .doc-sign-label {
            margin-bottom: 30px;
            font-size: 9pt;
            font-weight: 700;
        }

        .doc-sign-line {
            padding-top: 4px;
            text-align: center;
            border-top: 1px solid #222222;
        }

        .doc-sign-name {
            min-height: 12pt;
            font-size: 10pt;
            font-weight: 700;
        }

        .doc-sign-role {
            color: #444444;
            font-size: 8.5pt;
        }

        .doc-confidential {
            margin: 22px 0 0;
            color: #666666;
            font-size: 7.5pt;
            text-align: center;
        }

        @media print {
            html, body {
                background: #ffffff;
            }

            .print-toolbar {
                display: none !important;
            }

            .doc {
                max-width: none;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .doc-watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media screen and (max-width: 640px) {
            .doc {
                padding: 18px 14px;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

    <div class="print-toolbar" role="region" aria-label="Print controls">
        <p>
            <strong>Mother and Infant Health Record — {{ $mother->mother_code }}</strong>
            · {{ $isComplete ? 'Complete record' : count($selected) . ' selected ' . (count($selected) === 1 ? 'section' : 'sections') }}.
            The print dialog opens automatically.
        </p>
        <div class="print-toolbar-actions">
            <a href="{{ $recordUrl }}" class="print-btn print-btn-secondary">← Back to Record</a>
            <button type="button" class="print-btn print-btn-primary" onclick="window.print()">Print</button>
        </div>
    </div>

    <main class="doc">
        @include('reports.patients.partials.document', [
            'logoSrc' => asset('images/system.logo.png'),
            'rhuLogoSrc' => is_file(public_path('images/irosin-rhu-logo.jpg')) ? asset('images/irosin-rhu-logo.jpg') : null,
        ])
    </main>

    <script>
        // Open the print dialog once fonts and the logo have loaded.
        window.addEventListener('load', function () {
            var open = function () { window.setTimeout(function () { window.print(); }, 250); };
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(open);
            } else {
                open();
            }
        });
    </script>
</body>
</html>
