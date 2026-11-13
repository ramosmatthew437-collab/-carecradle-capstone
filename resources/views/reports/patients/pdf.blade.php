<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mother and Infant Health Record — {{ $mother->mother_code }}</title>
    <style>
        /*
         * DomPDF layout (same conventions as the existing report PDFs:
         * DejaVu fonts, tables only). Footer with page numbers is fixed so
         * it repeats on every page.
         */
        @page {
            margin: 16mm 12mm 20mm;
        }

        body {
            margin: 0;
            color: #111111;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 9pt;
            line-height: 1.35;
        }

        .pdf-footer {
            position: fixed;
            right: 0;
            bottom: -12mm;
            left: 0;
            height: 8mm;
            color: #666666;
            font-size: 7pt;
            border-top: 1px solid #e3c9d6;
        }

        .pdf-footer table {
            width: 100%;
            border-collapse: collapse;
        }

        .pdf-footer td {
            padding-top: 3px;
        }

        .pdf-footer .right {
            width: 30mm;
            text-align: right;
        }

        /* Official RHU watermark. Fixed elements repeat on every DomPDF page;
           coordinates are inside the page margins (content box 186 x 261 mm),
           so this centres a 110 mm logo (original 1228x1281 ratio). */
        .doc-watermark {
            position: fixed;
            top: 73mm;
            left: 38mm;
            width: 110mm;
            height: 114.7mm;
            z-index: -1;
        }

        .doc-watermark img {
            width: 110mm;
            height: 114.7mm;
            opacity: 0.04;
        }

        .doc-letterhead {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #9d174d;
        }

        .doc-letterhead td {
            padding: 0 0 6px;
            vertical-align: middle;
        }

        .doc-letterhead-logo {
            width: 60px;
        }

        .doc-letterhead-logo img {
            width: 54px;
            height: 54px;
        }

        /* Official RHU logo: right-aligned. Explicit size that keeps the
           original 1228x1281 ratio (DomPDF sizes images most reliably with
           both dimensions set). */
        .doc-letterhead-logo-rhu {
            text-align: right;
        }

        .doc-letterhead-logo img.doc-rhu-logo {
            width: 52px;
            height: 54.2px;
        }

        .doc-letterhead-text {
            text-align: center;
        }

        .doc-municipality {
            font-size: 9.5pt;
        }

        .doc-office {
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .doc-system {
            color: #555555;
            font-size: 8pt;
        }

        .doc-title {
            margin: 10px 0 0;
            color: #4a0d2a;
            font-family: "DejaVu Serif", serif;
            font-size: 16pt;
            font-weight: normal;
            text-align: center;
        }

        .doc-subtitle {
            margin: 2px 0 10px;
            color: #555555;
            font-size: 8pt;
            text-align: center;
        }

        .doc-id,
        .doc-kv,
        .doc-table,
        .doc-signatures {
            width: 100%;
            border-collapse: collapse;
        }

        .doc-id th,
        .doc-id td,
        .doc-kv th,
        .doc-kv td {
            padding: 4px 6px;
            font-size: 8.5pt;
            text-align: left;
            vertical-align: top;
            border: 1px solid #d9d9d9;
        }

        .doc-id th,
        .doc-kv th {
            width: 19%;
            color: #444444;
            font-weight: bold;
            background: #fbf3f7;
        }

        .doc-id td {
            font-weight: bold;
        }

        .doc-kv {
            margin-top: 7px;
        }

        .doc-kv .doc-kv-group {
            color: #9d174d;
            font-size: 8.5pt;
            text-transform: uppercase;
            background: #f3e1ea;
        }

        .doc-h2 {
            margin: 14px 0 5px;
            padding-bottom: 2px;
            color: #4a0d2a;
            font-family: "DejaVu Serif", serif;
            font-size: 12pt;
            font-weight: normal;
            border-bottom: 1px solid #e7c6d6;
            page-break-after: avoid;
        }

        .doc-h3 {
            margin: 10px 0 4px;
            color: #4a0d2a;
            font-family: "DejaVu Serif", serif;
            font-size: 10.5pt;
            font-weight: normal;
            page-break-after: avoid;
        }

        .doc-h3-meta {
            color: #666666;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 7.5pt;
        }

        .doc-h4 {
            margin: 8px 0 3px;
            color: #9d174d;
            font-size: 8.5pt;
            font-weight: bold;
            page-break-after: avoid;
        }

        .doc-table th {
            padding: 4px 5px;
            font-size: 7.5pt;
            font-weight: bold;
            text-align: left;
            background: #f3e1ea;
            border: 1px solid #d0b3c1;
        }

        .doc-table td {
            padding: 3px 5px;
            font-size: 8pt;
            vertical-align: top;
            border: 1px solid #dddddd;
        }

        .doc-keep {
            page-break-inside: avoid;
        }

        .doc-detail-row td {
            color: #333333;
            font-size: 7.5pt;
            background: #fcf9fb;
        }

        .doc-empty,
        .doc-note {
            margin: 3px 0;
            color: #555555;
            font-size: 8pt;
        }

        .doc-note {
            font-style: italic;
        }

        .doc-signatures {
            margin-top: 30px;
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
            margin-bottom: 26px;
            font-size: 8.5pt;
            font-weight: bold;
        }

        .doc-sign-line {
            padding-top: 3px;
            text-align: center;
            border-top: 1px solid #222222;
        }

        .doc-sign-name {
            font-size: 9.5pt;
            font-weight: bold;
        }

        .doc-sign-role {
            color: #444444;
            font-size: 8pt;
        }

        .doc-confidential {
            margin: 18px 0 0;
            color: #666666;
            font-size: 7pt;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="pdf-footer">
        <table>
            <tr>
                <td>CareCradle · Irosin Rural Health Unit · Mother Code {{ $mother->mother_code }} · Printed {{ $printedAt->format('M d, Y') }}</td>
                {{-- "Page X of Y" is drawn here by PatientRecordController::addPdfPageNumbers(),
                     because DomPDF cannot fill in the CSS total-page counter. --}}
                <td class="right"></td>
            </tr>
        </table>
    </div>

    {{-- DomPDF needs a local file path for images (remote loading is disabled).
         A small JPEG copy of the logo is used because DomPDF embeds JPEGs without
         the GD extension (PNGs require GD). If the file is missing, the
         letterhead falls back to text only. --}}
    @php
        $pdfLogoPath = public_path('images/pdf-letterhead-logo.jpg');
        // Official RHU logo: the original JPEG (embedded without GD).
        $pdfRhuLogoPath = public_path('images/irosin-rhu-logo.jpg');
    @endphp
    @include('reports.patients.partials.document', [
        'logoSrc' => is_file($pdfLogoPath) ? $pdfLogoPath : null,
        'rhuLogoSrc' => is_file($pdfRhuLogoPath) ? $pdfRhuLogoPath : null,
    ])

</body>
</html>
