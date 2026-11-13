<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infant;
use App\Models\Mother;
use App\Services\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * RHU Patient Records Center — Patient Records (Administrator).
 *
 * READ-ONLY. Administrators may search, view, print, and export patient
 * records as PDF. This controller intentionally has no create, store,
 * edit, update, or destroy actions; patient data is only changed through
 * the existing Midwife workflows.
 */
class PatientRecordController extends Controller
{
    /** Maternal status values that can be used as a filter. */
    private const STATUSES = ['Pregnant', 'Delivered', 'Referred'];

    /** Results shown per page. */
    private const PER_PAGE = 15;

    /**
     * Record sections that can be printed / exported (key => label).
     * Labels are used in audit descriptions; they contain no patient data.
     */
    public const SECTIONS = [
        'overview' => "Mother's Information",
        'prenatal' => 'Prenatal Visits',
        'maternal_vaccinations' => 'Maternal Vaccinations',
        'appointments' => 'Appointments',
        'postpartum' => 'Postpartum & Delivery',
        'infants' => 'Infant Records',
    ];

    /**
     * Patient search.
     *
     * Matches a mother by name (including full name), Mother Code
     * (the patient ID), contact number (09… or +639… form), or the name
     * of one of her infants — an infant-name match returns the mother.
     * Optional filters: barangay and maternal status.
     */
    public function index(Request $request, ActivityLogger $activityLogger): View
    {
        $search = mb_substr(trim((string) $request->query('search', '')), 0, 100);

        $status = (string) $request->query('status', '');
        if (! in_array($status, self::STATUSES, true)) {
            $status = '';
        }

        $barangays = Mother::query()
            ->whereNotNull('barangay')
            ->where('barangay', '!=', '')
            ->distinct()
            ->orderBy('barangay')
            ->pluck('barangay');

        $barangay = (string) $request->query('barangay', '');
        if (! $barangays->contains($barangay)) {
            $barangay = '';
        }

        // A submitted search form always sends all three fields, even when
        // "All Status" / "All Barangays" (empty values) are chosen. Treat a
        // submitted form as a search so "All Status" lists mothers of every
        // status instead of falling back to the empty "Search for a patient"
        // prompt. A plain visit with no query string still shows the prompt.
        $formSubmitted = $request->query->has('search')
            || $request->query->has('status')
            || $request->query->has('barangay');

        $hasCriteria = $formSubmitted || $search !== '' || $status !== '' || $barangay !== '';

        $mothers = null;

        if ($hasCriteria) {
            $mothers = Mother::query()
                ->select([
                    'id', 'mother_code', 'first_name', 'middle_name', 'last_name',
                    'barangay', 'contact_number', 'status',
                ])
                ->withCount(['infants', 'prenatalCheckups'])
                ->when($search !== '', fn (Builder $query) => $this->applySearch($query, $search))
                ->when($status === 'Referred', fn (Builder $query) => $query->referred())
                ->when($status !== '' && $status !== 'Referred', fn (Builder $query) => $query->where('status', $status))
                ->withReferralFlag()
                ->when($barangay !== '', fn (Builder $query) => $query->where('barangay', $barangay))
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->paginate(self::PER_PAGE)
                ->withQueryString();

            // Load only the infants whose names match, so the results can
            // explain why a mother was returned for an infant-name search.
            if ($search !== '') {
                $like = '%' . $search . '%';
                $mothers->getCollection()->load(['infants' => function ($query) use ($like) {
                    $query->select(['id', 'mother_id', 'first_name', 'middle_name', 'last_name'])
                        ->where(function ($q) use ($like) {
                            $q->where('first_name', 'like', $like)
                                ->orWhere('middle_name', 'like', $like)
                                ->orWhere('last_name', 'like', $like)
                                ->orWhereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", [$like])
                                ->orWhereRaw("CONCAT_WS(' ', first_name, last_name) LIKE ?", [$like]);
                        });
                }]);
            }

            // Audit: record that a search was run and which kinds of
            // criteria were used. The search text itself is NOT logged,
            // because it may contain a patient's name.
            $criteria = array_filter([
                $search !== '' ? 'search term' : null,
                $status !== '' ? 'status' : null,
                $barangay !== '' ? 'barangay' : null,
            ]);

            $activityLogger->log(
                'searched',
                'Patient Records',
                'Searched patient records using: '
                    . ($criteria === [] ? 'no filters (all statuses and barangays)' : implode(', ', $criteria))
                    . ' (' . $mothers->total() . ' matching ' . ($mothers->total() === 1 ? 'mother' : 'mothers') . ').'
            );
        }

        return view('reports.patients.index', [
            'mothers' => $mothers,
            'search' => $search,
            'status' => $status,
            'barangay' => $barangay,
            'barangays' => $barangays,
            'statuses' => self::STATUSES,
            'hasCriteria' => $hasCriteria,
            // Global totals: deliberately NOT affected by search or filters.
            'totalMothers' => Mother::query()->count(),
            'totalInfants' => Infant::query()->count(),
        ]);
    }

    /**
     * Consolidated, read-only patient record: the mother's information,
     * prenatal visits, maternal vaccinations, appointments, a Postpartum &
     * Delivery summary built from existing data, and every related infant
     * with growth monitoring and vaccination history.
     *
     * Every page load is written to the Activity Logs (actor, time, IP,
     * browser, and the Mother Code only — no names or medical details).
     */
    public function show(Mother $mother, ActivityLogger $activityLogger): View
    {
        $this->loadRecord($mother);

        $activityLogger->log(
            'viewed',
            'Patient Records',
            "Viewed patient record (code: {$mother->mother_code}).",
            $mother->id
        );

        return view('reports.patients.show', [
            'mother' => $mother,
            'backUrl' => $this->searchBackUrl(),
            'sections' => self::SECTIONS,
        ]);
    }

    /**
     * Dedicated print layout (complete record or selected sections).
     *
     * The page opens the browser's print dialog. Because printing happens
     * in the browser, the server can only know the print page was opened,
     * so the audit entry says "print page opened" — not "printed".
     */
    public function print(Request $request, Mother $mother, ActivityLogger $activityLogger): View
    {
        $this->loadRecord($mother);
        $selected = $this->selectedSections($request);

        $activityLogger->log(
            'print_requested',
            'Patient Records',
            "Print page opened for patient record (code: {$mother->mother_code}; sections: "
                . $this->sectionLabels($selected) . ').',
            $mother->id
        );

        return view('reports.patients.print', $this->documentData($mother, $selected) + [
            'recordUrl' => route('reports.patients.show', $mother),
        ]);
    }

    /**
     * PDF export (complete record or selected sections), generated with
     * the project's existing DomPDF package. The audit entry records the
     * export request.
     */
    public function pdf(Request $request, Mother $mother, ActivityLogger $activityLogger): Response
    {
        $this->loadRecord($mother);
        $selected = $this->selectedSections($request);

        $activityLogger->log(
            'pdf_export_requested',
            'Patient Records',
            "PDF export requested for patient record (code: {$mother->mother_code}; sections: "
                . $this->sectionLabels($selected) . ').',
            $mother->id
        );

        $pdf = Pdf::loadView('reports.patients.pdf', $this->documentData($mother, $selected))
            ->setPaper('a4', 'portrait')
            // Embed only the font characters used (keeps the file small).
            // Applies to this export only; the existing report PDFs are unchanged.
            ->setOption('isFontSubsettingEnabled', true);

        // Lay out the pages first so the total page count is known, then
        // write "Page X of Y" into each page footer.
        $pdf->render();
        $this->addPdfPageNumbers($pdf->getDomPDF());

        $fileName = 'Mother_Infant_Health_Record_' . preg_replace('/[^A-Za-z0-9-]/', '', (string) $mother->mother_code)
            . (count($selected) < count(self::SECTIONS) ? '_Selected_Sections' : '')
            . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Write "Page X of Y" in the bottom-right corner of every PDF page.
     *
     * DomPDF does not fill in the CSS total-page counter, so the numbers are
     * drawn with DomPDF's own page script, which receives the page number and
     * the final page count. A PHP callback is used (not a script string), so
     * DomPDF's inline-PHP option stays disabled.
     *
     * The position matches the footer in reports/patients/pdf.blade.php:
     * 12 mm right page margin; the footer text row sits 16 mm above the
     * bottom edge of the page.
     */
    private function addPdfPageNumbers(\Dompdf\Dompdf $dompdf): void
    {
        $mm = 72 / 25.4;
        $fontSize = 7;
        $color = [0.4, 0.4, 0.4]; // #666666, same as the footer text
        $font = $dompdf->getFontMetrics()->getFont('DejaVu Sans');

        $dompdf->getCanvas()->page_script(
            function (int $pageNumber, int $pageCount, $canvas, $fontMetrics) use ($mm, $fontSize, $color, $font) {
                $text = "Page {$pageNumber} of {$pageCount}";
                $width = $fontMetrics->getTextWidth($text, $font, $fontSize);

                $canvas->text(
                    $canvas->get_width() - (12 * $mm) - $width,
                    $canvas->get_height() - (16 * $mm) + 3.8,
                    $text,
                    $font,
                    $fontSize,
                    $color
                );
            }
        );
    }

    /**
     * Load everything the record, print, and PDF views display.
     * Laboratory attachments: file names only — the stored path is never loaded.
     */
    private function loadRecord(Mother $mother): void
    {
        $mother->load([
            'user:id,username',
            'prenatalCheckups' => fn ($query) => $query
                ->orderByDesc('visit_date')
                ->orderByDesc('id'),
            'prenatalCheckups.attachments' => fn ($query) => $query
                ->select(['id', 'prenatal_checkup_id', 'file_name', 'mime_type', 'file_size', 'created_at'])
                ->orderBy('id'),
            'maternalVaccinations' => fn ($query) => $query
                ->orderByDesc('date_given')
                ->orderByDesc('id'),
            'appointments' => fn ($query) => $query
                ->orderByDesc('appointment_date')
                ->orderByDesc('appointment_time'),
            'infants' => fn ($query) => $query
                ->orderBy('birth_date')
                ->orderBy('id'),
            'infants.growthMonitorings',
            'infants.vaccinations',
            'referrals',
        ]);
    }

    /**
     * Sections requested via ?sections[]=… (allow-listed, in document
     * order). No valid selection means the complete record.
     *
     * @return array<int, string>
     */
    private function selectedSections(Request $request): array
    {
        $requested = $request->query('sections');
        $requested = is_array($requested) ? $requested : [];

        $selected = array_values(array_filter(
            array_keys(self::SECTIONS),
            fn ($key) => in_array($key, $requested, true)
        ));

        return $selected ?: array_keys(self::SECTIONS);
    }

    /** "Complete record" or a list of section labels (no patient data). */
    private function sectionLabels(array $selected): string
    {
        if (count($selected) === count(self::SECTIONS)) {
            return 'complete record';
        }

        return implode(', ', array_map(fn ($key) => self::SECTIONS[$key], $selected));
    }

    /** Data shared by the print and PDF documents. */
    private function documentData(Mother $mother, array $selected): array
    {
        $user = request()->user();

        return [
            'mother' => $mother,
            'selected' => $selected,
            'sectionNames' => self::SECTIONS,
            'isComplete' => count($selected) === count(self::SECTIONS),
            'preparedByName' => $user?->name,
            'preparedByRole' => $user?->role,
            'printedAt' => now(),
        ];
    }

    /**
     * Back link to the search results the Administrator came from — only
     * when the previous page really was the search page (with any query).
     */
    private function searchBackUrl(): string
    {
        $searchUrl = route('reports.patients.index');
        $previous = url()->previous();

        if (parse_url($previous, PHP_URL_PATH) !== parse_url($searchUrl, PHP_URL_PATH)) {
            return $searchUrl;
        }

        // Rebuild on this application's own URL; keep only the query string.
        $query = parse_url($previous, PHP_URL_QUERY);

        return $query ? $searchUrl . '?' . $query : $searchUrl;
    }

    /**
     * Name, full name, Mother Code, contact number, or infant name.
     */
    private function applySearch(Builder $query, string $search): void
    {
        $like = '%' . $search . '%';
        $phoneVariants = $this->phoneVariants($search);

        $query->where(function (Builder $q) use ($like, $phoneVariants) {
            $q->where('mother_code', 'like', $like)
                ->orWhere('first_name', 'like', $like)
                ->orWhere('middle_name', 'like', $like)
                ->orWhere('last_name', 'like', $like)
                ->orWhereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", [$like])
                ->orWhereRaw("CONCAT_WS(' ', first_name, last_name) LIKE ?", [$like]);

            foreach ($phoneVariants as $variant) {
                $q->orWhere('contact_number', 'like', '%' . $variant . '%');
            }

            // Infant name -> associated mother
            $q->orWhereHas('infants', function (Builder $infant) use ($like) {
                $infant->where('first_name', 'like', $like)
                    ->orWhere('middle_name', 'like', $like)
                    ->orWhere('last_name', 'like', $like)
                    ->orWhereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", [$like])
                    ->orWhereRaw("CONCAT_WS(' ', first_name, last_name) LIKE ?", [$like]);
            });
        });
    }

    /**
     * Contact-number forms to try for a search that looks like a phone
     * number: the digits as typed, the local 09… form and the +639… form.
     * Only searches made of digits and phone punctuation (spaces, +, -,
     * parentheses) are treated as phone numbers, so a Mother Code such as
     * "MTH-000012" does not also match unrelated contact numbers.
     * Fewer than 4 digits is not treated as a phone search.
     *
     * @return array<int, string>
     */
    private function phoneVariants(string $search): array
    {
        if (! preg_match('/^[\d\s+\-()]+$/', $search)) {
            return [];
        }

        $digits = preg_replace('/\D+/', '', $search);

        if (strlen($digits) < 4) {
            return [];
        }

        $variants = [$digits];

        if (str_starts_with($digits, '63')) {
            $local = '0' . substr($digits, 2);
        } elseif (str_starts_with($digits, '9')) {
            $local = '0' . $digits;
        } else {
            $local = $digits;
        }

        $variants[] = $local;

        if (str_starts_with($local, '0')) {
            $variants[] = '+63' . substr($local, 1);
        }

        return array_values(array_unique($variants));
    }
}
