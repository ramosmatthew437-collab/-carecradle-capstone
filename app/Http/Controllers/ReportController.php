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

    public function appointments(Request $request)
    {
        $query = Appointment::with('mother');

        // Search by mother's name
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('mother', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('appointment_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('appointment_date', '<=', $request->to);
        }

        $appointments = $query
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Summary Cards
        $totalAppointments = $appointments->count();

        $scheduled = $appointments
            ->where('status', 'Scheduled')
            ->count();

        $completed = $appointments
            ->where('status', 'Completed')
            ->count();

        $cancelled = $appointments
            ->where('status', 'Cancelled')
            ->count();

        $missed = $appointments
            ->where('status', 'Missed')
            ->count();

        return view('reports.appointments', compact(
            'appointments',
            'totalAppointments',
            'scheduled',
            'completed',
            'cancelled',
            'missed'
        ));
    }

    public function mothers(Request $request)
{
    $query = Mother::query();

    // Search by Mother Code or Name
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('mother_code', 'like', "%{$search}%")
              ->orWhere('first_name', 'like', "%{$search}%")
              ->orWhere('middle_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%");
        });
    }

    // Filter by Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter by Barangay
    if ($request->filled('barangay')) {
        $query->where('barangay', $request->barangay);
    }

    $mothers = $query
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    // Summary Statistics
    $totalMothers = Mother::count();

    $pregnant = Mother::where('status', 'Pregnant')->count();

    $delivered = Mother::where('status', 'Delivered')->count();

    $referred = Mother::where('status', 'Referred')->count();

    // Barangay List for Filter
    $barangays = Mother::select('barangay')
        ->distinct()
        ->orderBy('barangay')
        ->pluck('barangay');

    return view('reports.mothers', compact(
        'mothers',
        'barangays',
        'totalMothers',
        'pregnant',
        'delivered',
        'referred'
    ));
}

   public function infants(Request $request)
{
    $query = Infant::with('mother');

    // Search
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('middle_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%");

        });

    }

    // Filter by Sex
    if ($request->filled('sex')) {

        $query->where('sex', $request->sex);

    }

    $infants = $query
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    $totalInfants = Infant::count();

    $male = Infant::where('sex', 'Male')->count();

    $female = Infant::where('sex', 'Female')->count();

    return view('reports.infants', compact(
        'infants',
        'totalInfants',
        'male',
        'female'
    ));
}
public function vaccinations(Request $request)
{
    $query = Vaccination::with('infant.mother');

    // Search
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('vaccine_name', 'like', "%{$search}%")
              ->orWhere('dose', 'like', "%{$search}%");

        });

    }

    $vaccinations = $query
        ->orderBy('date_given', 'desc')
        ->get();

    $totalVaccinations = Vaccination::count();

    $totalInfants = Vaccination::distinct('infant_id')->count('infant_id');

    $vaccineTypes = Vaccination::distinct('vaccine_name')->count('vaccine_name');

    return view('reports.vaccinations', compact(

        'vaccinations',

        'totalVaccinations',

        'totalInfants',

        'vaccineTypes'

    ));
}

    public function appointmentsPdf()
{
    $appointments = Appointment::with('mother')
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
    ]);

    return $pdf->download('Appointment_Report.pdf');
}


public function mothersPdf()
{
    $mothers = Mother::orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    $totalMothers = $mothers->count();

    $pregnant = $mothers->where('status', 'Pregnant')->count();

    $delivered = $mothers->where('status', 'Delivered')->count();

    $referred = $mothers->where('status', 'Referred')->count();

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
public function infantsPdf()
{
    $infants = Infant::with('mother')
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

public function vaccinationsPdf()
{
    $vaccinations = Vaccination::with('infant.mother')
        ->orderByDesc('date_given')
        ->get();

    $totalVaccinations = $vaccinations->count();

    $totalInfants = $vaccinations
        ->pluck('infant_id')
        ->unique()
        ->count();

    $vaccineTypes = $vaccinations
        ->pluck('vaccine_name')
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
