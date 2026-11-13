<?php

namespace App\Http\Controllers;



use App\Models\Appointment;
use App\Models\Mother;
use App\Models\Infant;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    /*
    |--------------------------------------------------------------------------
    | Appointment Report
    |--------------------------------------------------------------------------
    */

    public function appointments(Request $request)
    {
        $query = Appointment::with('mother');

        // Search by mother's name.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('mother', function ($q) use ($search) {
                $q->where(function ($nameQuery) use ($search) {
                    $nameQuery->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range.
        if ($request->filled('from')) {
            $query->whereDate('appointment_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('appointment_date', '<=', $request->to);
        }

        // Filter by mother's barangay.
        if ($request->filled('barangay')) {
            $query->whereHas('mother', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $appointments = $query
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Totals use the filtered appointments.
        $totalAppointments = $appointments->count();
        $scheduled = $appointments->where('status', 'Scheduled')->count();
        $completed = $appointments->where('status', 'Completed')->count();
        $cancelled = $appointments->where('status', 'Cancelled')->count();
        $missed = $appointments->where('status', 'Missed')->count();

        // Dropdown options.
        $barangays = Mother::whereNotNull('barangay')
            ->where('barangay', '!=', '')
            ->distinct()
            ->orderBy('barangay')
            ->pluck('barangay');

        return view('reports.appointments', compact(
            'appointments',
            'totalAppointments',
            'scheduled',
            'completed',
            'cancelled',
            'missed',
            'barangays'
        ));
    }

    public function appointmentsPdf(Request $request)
    {
        $query = Appointment::with('mother');

        // Search by mother's name.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('mother', function ($q) use ($search) {
                $q->where(function ($nameQuery) use ($search) {
                    $nameQuery->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by status.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range.
        if ($request->filled('from')) {
            $query->whereDate('appointment_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('appointment_date', '<=', $request->to);
        }

        // Filter by mother's barangay.
        if ($request->filled('barangay')) {
            $query->whereHas('mother', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $appointments = $query
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $totalAppointments = $appointments->count();
        $scheduled = $appointments->where('status', 'Scheduled')->count();
        $completed = $appointments->where('status', 'Completed')->count();
        $cancelled = $appointments->where('status', 'Cancelled')->count();
        $missed = $appointments->where('status', 'Missed')->count();

        $pdf = Pdf::loadView('reports.pdf.appointments', [
            'appointments' => $appointments,
            'generatedDate' => now(),
            'totalAppointments' => $totalAppointments,
            'scheduled' => $scheduled,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'missed' => $missed,
        ]);

        return $pdf->download('Appointment_Report.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | Mother Report
    |--------------------------------------------------------------------------
    */

    public function mothers(Request $request)
    {
        $query = Mother::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('mother_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Pregnancy status filter; "Referred" means currently referred
        // (active referral, or an older Referred record).
        if ($request->filled('status')) {
            $request->status === 'Referred'
                ? $query->referred()
                : $query->where('status', $request->status);
        }

        if ($request->filled('barangay')) {
            $query->where('barangay', $request->barangay);
        }

        $mothers = $query
            ->withReferralFlag()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $totalMothers = $mothers->count();
        $pregnant = $mothers->where('status', 'Pregnant')->count();
        $delivered = $mothers->where('status', 'Delivered')->count();
        $referred = $mothers->filter(fn ($m) => $m->isReferred())->count();

        $barangays = Mother::whereNotNull('barangay')
            ->where('barangay', '!=', '')
            ->distinct()
            ->orderBy('barangay')
            ->pluck('barangay');

        return view('reports.mothers', compact(
            'mothers',
            'totalMothers',
            'pregnant',
            'delivered',
            'referred',
            'barangays'
        ));
    }

    public function mothersPdf(Request $request)
    {
        $query = Mother::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('mother_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Pregnancy status filter; "Referred" means currently referred
        // (active referral, or an older Referred record).
        if ($request->filled('status')) {
            $request->status === 'Referred'
                ? $query->referred()
                : $query->where('status', $request->status);
        }

        if ($request->filled('barangay')) {
            $query->where('barangay', $request->barangay);
        }

        $mothers = $query
            ->withReferralFlag()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $totalMothers = $mothers->count();
        $pregnant = $mothers->where('status', 'Pregnant')->count();
        $delivered = $mothers->where('status', 'Delivered')->count();
        $referred = $mothers->filter(fn ($m) => $m->isReferred())->count();

        $pdf = Pdf::loadView('reports.pdf.mothers', [
            'mothers' => $mothers,
            'generatedDate' => now(),
            'totalMothers' => $totalMothers,
            'pregnant' => $pregnant,
            'delivered' => $delivered,
            'referred' => $referred,
        ]);

        return $pdf->download('Mother_Report.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | Infant Report
    |--------------------------------------------------------------------------
    */

    public function infants(Request $request)
    {
        $query = Infant::with('mother');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('barangay')) {
            $query->whereHas('mother', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $infants = $query
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $totalInfants = $infants->count();
        $male = $infants->where('sex', 'Male')->count();
        $female = $infants->where('sex', 'Female')->count();

        $barangays = Mother::whereNotNull('barangay')
            ->where('barangay', '!=', '')
            ->distinct()
            ->orderBy('barangay')
            ->pluck('barangay');

        return view('reports.infants', compact(
            'infants',
            'totalInfants',
            'male',
            'female',
            'barangays'
        ));
    }

    public function infantsPdf(Request $request)
    {
        $query = Infant::with('mother');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('barangay')) {
            $query->whereHas('mother', function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            });
        }

        $infants = $query
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $totalInfants = $infants->count();
        $male = $infants->where('sex', 'Male')->count();
        $female = $infants->where('sex', 'Female')->count();

        $pdf = Pdf::loadView('reports.pdf.infants', [
            'infants' => $infants,
            'generatedDate' => now(),
            'totalInfants' => $totalInfants,
            'male' => $male,
            'female' => $female,
        ]);

        return $pdf->download('Infant_Report.pdf');
    }

    
/*
|--------------------------------------------------------------------------
| Vaccination Report
|--------------------------------------------------------------------------
*/

public function vaccinations(Request $request)
{
    $query = Vaccination::with('infant.mother');

    // Search by vaccine name, dose, or infant name.
    if ($request->filled('search')) {
        $search = trim($request->input('search'));

        $query->where(function ($q) use ($search) {
            $q->where('vaccine_name', 'like', "%{$search}%")
                ->orWhere('dose', 'like', "%{$search}%")
                ->orWhereHas('infant', function ($infantQuery) use ($search) {
                    $infantQuery->where(function ($nameQuery) use ($search) {
                        $nameQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('middle_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw(
                                "CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?",
                                ["%{$search}%"]
                            );
                    });
                });
        });
    }

    // Filter by the infant's mother's barangay.
    if ($request->filled('barangay')) {
        $query->whereHas('infant.mother', function ($q) use ($request) {
            $q->where('barangay', $request->input('barangay'));
        });
    }

    // Retrieve the filtered vaccination records.
    $vaccinations = $query
        ->orderBy('date_given', 'desc')
        ->get();

    // Calculate totals from filtered records only.
    $totalVaccinations = $vaccinations->count();

    $totalInfants = $vaccinations
        ->pluck('infant_id')
        ->unique()
        ->count();

    $vaccineTypes = $vaccinations
        ->pluck('vaccine_name')
        ->filter()
        ->unique()
        ->count();

    // Populate the barangay dropdown.
    $barangays = Mother::whereNotNull('barangay')
        ->where('barangay', '!=', '')
        ->distinct()
        ->orderBy('barangay')
        ->pluck('barangay');

    return view('reports.vaccinations', compact(
        'vaccinations',
        'totalVaccinations',
        'totalInfants',
        'vaccineTypes',
        'barangays'
    ));
}

public function vaccinationsPdf(Request $request)
{
    $query = Vaccination::with('infant.mother');

    // Use the same search conditions as the webpage.
    if ($request->filled('search')) {
        $search = trim($request->input('search'));

        $query->where(function ($q) use ($search) {
            $q->where('vaccine_name', 'like', "%{$search}%")
                ->orWhere('dose', 'like', "%{$search}%")
                ->orWhereHas('infant', function ($infantQuery) use ($search) {
                    $infantQuery->where(function ($nameQuery) use ($search) {
                        $nameQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('middle_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhereRaw(
                                "CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?",
                                ["%{$search}%"]
                            );
                    });
                });
        });
    }

    // Preserve the selected barangay filter.
    if ($request->filled('barangay')) {
        $query->whereHas('infant.mother', function ($q) use ($request) {
            $q->where('barangay', $request->input('barangay'));
        });
    }

    // Retrieve only matching vaccination records.
    $vaccinations = $query
        ->orderBy('date_given', 'desc')
        ->get();

    // Calculate PDF totals from filtered records.
    $totalVaccinations = $vaccinations->count();

    $totalInfants = $vaccinations
        ->pluck('infant_id')
        ->unique()
        ->count();

    $vaccineTypes = $vaccinations
        ->pluck('vaccine_name')
        ->filter()
        ->unique()
        ->count();

    $pdf = Pdf::loadView('reports.pdf.vaccinations', [
        'vaccinations' => $vaccinations,
        'generatedDate' => now(),
        'totalVaccinations' => $totalVaccinations,
        'totalInfants' => $totalInfants,
        'vaccineTypes' => $vaccineTypes,
    ]);

    return $pdf->download('Vaccination_Report.pdf');
}



    

    
}