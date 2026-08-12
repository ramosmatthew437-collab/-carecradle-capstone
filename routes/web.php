<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MidwifeController;
use App\Http\Controllers\Admin\MotherController;
use App\Http\Controllers\InfantController;
use App\Http\Controllers\GrowthMonitoringController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SmsNotificationController;
use App\Http\Controllers\Mother\MotherDashboardController;
use App\Http\Controllers\Mother\MotherProfileController;
use App\Http\Controllers\Mother\MotherAppointmentController;
use App\Http\Controllers\Mother\MotherSmsController;
use App\Http\Controllers\Mother\MotherPrenatalController;
use App\Http\Controllers\Mother\MotherInfantController;
use App\Http\Controllers\Mother\MotherGrowthMonitoringController;
use App\Http\Controllers\Mother\MotherVaccinationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile (All Authenticated Users)
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Administrator Only
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:Administrator'])->group(function () {

        // Midwife Management
        Route::post('/midwives/{midwife}/activate', [MidwifeController::class, 'activate'])
            ->name('midwives.activate');

        Route::resource('midwives', MidwifeController::class);

        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
        Route::get('/reports/mothers', [ReportController::class, 'mothers'])->name('reports.mothers');
        Route::get('/reports/infants', [ReportController::class, 'infants'])->name('reports.infants');
        Route::get('/reports/vaccinations', [ReportController::class, 'vaccinations'])->name('reports.vaccinations');

        Route::get('/reports/appointments/pdf', [ReportController::class, 'appointmentsPdf'])->name('reports.appointments.pdf');
        Route::get('/reports/mothers/pdf', [ReportController::class, 'mothersPdf'])->name('reports.mothers.pdf');
        Route::get('/reports/infants/pdf', [ReportController::class, 'infantsPdf'])->name('reports.infants.pdf');
        Route::get('/reports/vaccinations/pdf', [ReportController::class, 'vaccinationsPdf'])->name('reports.vaccinations.pdf');

    });

    /*
    |--------------------------------------------------------------------------
    | Midwife Only
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:Midwife'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Mother Management
        |--------------------------------------------------------------------------
        */

        Route::resource('mothers', MotherController::class);

        /*
        |--------------------------------------------------------------------------
        | Prenatal Checkups
        |--------------------------------------------------------------------------
        */

        Route::get('/mothers/{mother}/prenatal-checkups/create',
            [\App\Http\Controllers\PrenatalCheckupController::class, 'create'])
            ->name('prenatal-checkups.create');

        Route::post('/mothers/{mother}/prenatal-checkups',
            [\App\Http\Controllers\PrenatalCheckupController::class, 'store'])
            ->name('prenatal-checkups.store');

        Route::get('/prenatal-checkups/{prenatalCheckup}',
            [\App\Http\Controllers\PrenatalCheckupController::class, 'show'])
            ->name('prenatal-checkups.show');

        Route::get('/prenatal-checkups/{prenatalCheckup}/edit',
            [\App\Http\Controllers\PrenatalCheckupController::class, 'edit'])
            ->name('prenatal-checkups.edit');

        Route::put('/prenatal-checkups/{prenatalCheckup}',
            [\App\Http\Controllers\PrenatalCheckupController::class, 'update'])
            ->name('prenatal-checkups.update');

        Route::delete('/prenatal-checkups/{prenatalCheckup}',
            [\App\Http\Controllers\PrenatalCheckupController::class, 'destroy'])
            ->name('prenatal-checkups.destroy');

        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        Route::get('/mothers/{mother}/appointments/create',
            [\App\Http\Controllers\AppointmentController::class, 'create'])
            ->name('appointments.create');

        Route::post('/mothers/{mother}/appointments',
            [\App\Http\Controllers\AppointmentController::class, 'store'])
            ->name('appointments.store');

        Route::get('/appointments/{appointment}',
            [\App\Http\Controllers\AppointmentController::class, 'show'])
            ->name('appointments.show');

        Route::get('/appointments/{appointment}/edit',
            [\App\Http\Controllers\AppointmentController::class, 'edit'])
            ->name('appointments.edit');

        Route::put('/appointments/{appointment}',
            [\App\Http\Controllers\AppointmentController::class, 'update'])
            ->name('appointments.update');

        Route::delete('/appointments/{appointment}',
            [\App\Http\Controllers\AppointmentController::class, 'destroy'])
            ->name('appointments.destroy');

        /*
        |--------------------------------------------------------------------------
        | SMS Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/sms-notifications',
            [\App\Http\Controllers\SmsNotificationController::class, 'index'])
            ->name('sms-notifications.index');

        Route::get('/sms-notifications/{smsNotification}',
            [\App\Http\Controllers\SmsNotificationController::class, 'show'])
            ->name('sms-notifications.show');

            Route::post('/sms-notifications/{smsNotification}/send', [SmsNotificationController::class, 'send'])
    ->name('sms-notifications.send');

        /*
        |--------------------------------------------------------------------------
        | Infant Records
        |--------------------------------------------------------------------------
        */

        Route::get('/mothers/{mother}/infants/create',
            [InfantController::class, 'create'])
            ->name('infants.create');

        Route::post('/mothers/{mother}/infants',
            [InfantController::class, 'store'])
            ->name('infants.store');

        Route::get('/infants/{infant}',
            [InfantController::class, 'show'])
            ->name('infants.show');

        Route::get('/infants/{infant}/edit',
            [InfantController::class, 'edit'])
            ->name('infants.edit');

        Route::put('/infants/{infant}',
            [InfantController::class, 'update'])
            ->name('infants.update');

        Route::delete('/infants/{infant}',
            [InfantController::class, 'destroy'])
            ->name('infants.destroy');

        /*
        |--------------------------------------------------------------------------
        | Growth Monitoring
        |--------------------------------------------------------------------------
        */

        Route::get('/infants/{infant}/growth-monitorings/create',
            [GrowthMonitoringController::class, 'create'])
            ->name('growth-monitorings.create');

        Route::post('/infants/{infant}/growth-monitorings',
            [GrowthMonitoringController::class, 'store'])
            ->name('growth-monitorings.store');

        Route::get('/growth-monitorings/{growthMonitoring}',
            [GrowthMonitoringController::class, 'show'])
            ->name('growth-monitorings.show');

        Route::get('/growth-monitorings/{growthMonitoring}/edit',
            [GrowthMonitoringController::class, 'edit'])
            ->name('growth-monitorings.edit');

        Route::put('/growth-monitorings/{growthMonitoring}',
            [GrowthMonitoringController::class, 'update'])
            ->name('growth-monitorings.update');

        Route::delete('/growth-monitorings/{growthMonitoring}',
            [GrowthMonitoringController::class, 'destroy'])
            ->name('growth-monitorings.destroy');

        /*
        |--------------------------------------------------------------------------
        | Vaccinations
        |--------------------------------------------------------------------------
        */

        Route::get('/infants/{infant}/vaccinations/create',
            [VaccinationController::class, 'create'])
            ->name('vaccinations.create');

        Route::post('/infants/{infant}/vaccinations',
            [VaccinationController::class, 'store'])
            ->name('vaccinations.store');

        Route::get('/vaccinations/{vaccination}',
            [VaccinationController::class, 'show'])
            ->name('vaccinations.show');

        Route::get('/vaccinations/{vaccination}/edit',
            [VaccinationController::class, 'edit'])
            ->name('vaccinations.edit');

        Route::put('/vaccinations/{vaccination}',
            [VaccinationController::class, 'update'])
            ->name('vaccinations.update');

        Route::delete('/vaccinations/{vaccination}',
            [VaccinationController::class, 'destroy'])
            ->name('vaccinations.destroy');

    });

    /*
    |--------------------------------------------------------------------------
    | Mother Portal
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:Mother'])->group(function () {

    Route::get('/mother/dashboard', [MotherDashboardController::class, 'index'])
        ->name('mother.dashboard');
        Route::get('/mother/profile', [MotherProfileController::class, 'index'])
    ->name('mother.profile');

    Route::get(
    '/mother/appointments',
    [MotherAppointmentController::class, 'index']
)->name('mother.appointments');


Route::get(
    '/mother/sms-history',
    [MotherSmsController::class, 'index']
)->name('mother.sms-history');

Route::get(
    '/mother/prenatal-records',
    [MotherPrenatalController::class, 'index']
)->name('mother.prenatal-records');

Route::get(
    '/mother/infant-records',
    [MotherInfantController::class, 'index']
)->name('mother.infant-records');

Route::get(
    '/mother/growth-monitoring',
    [MotherGrowthMonitoringController::class, 'index']
)->name('mother.growth-monitoring');

Route::get(
    '/mother/vaccinations',
    [MotherVaccinationController::class, 'index']
)->name('mother.vaccinations');
});

});

require __DIR__.'/auth.php';


use App\Services\TextBeeService;

Route::get('/test-sms', function (TextBeeService $textBee) {

    $result = $textBee->send(

        '+639925519539',

        'Hello! This is a test SMS from CareCradle 🚀'

    );

    dd($result);

});