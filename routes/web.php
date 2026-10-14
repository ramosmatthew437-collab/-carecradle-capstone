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
use App\Http\Controllers\HealthTipController;
use App\Http\Controllers\MidwifeHealthTipController;
use App\Http\Middleware\EnsurePrivacyConsent;
use App\Http\Controllers\PrivacyConsentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StaffConfidentialityController;
use App\Services\TextBeeService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([
        'auth',
        'verified',
        'staff.confidentiality',
    ])
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

    Route::middleware([
    'role:Administrator',
    'staff.confidentiality',
])->group(function () {


Route::get('/activity-logs', [
    \App\Http\Controllers\Admin\ActivityLogController::class,
    'index',
])->name('admin.activity-logs.index');

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

   
Route::middleware([
    'role:Midwife',
    'staff.confidentiality',
])->group(function () {

        Route::resource('midwife/health-tips', MidwifeHealthTipController::class)
            ->names('midwife.health-tips');

        Route::get('/test-midwife', function () {
            return view('test-midwife');
        });

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

    Route::middleware(['role:Mother', EnsurePrivacyConsent::class])->group(function () {

        Route::get('/mother/dashboard', [MotherDashboardController::class, 'index'])
            ->name('mother.dashboard');

        Route::get('/mother/profile', [MotherProfileController::class, 'index'])
            ->name('mother.profile');

        Route::get('/mother/appointments', [MotherAppointmentController::class, 'index'])
            ->name('mother.appointments');

        Route::get('/mother/sms-history', [MotherSmsController::class, 'index'])
            ->name('mother.sms-history');

        Route::get('/mother/prenatal-records', [MotherPrenatalController::class, 'index'])
            ->name('mother.prenatal-records');

        Route::get('/mother/infant-records', [MotherInfantController::class, 'index'])
            ->name('mother.infant-records');

        Route::get('/mother/growth-monitoring', [MotherGrowthMonitoringController::class, 'index'])
            ->name('mother.growth-monitoring');

        Route::get('/mother/vaccinations', [MotherVaccinationController::class, 'index'])
            ->name('mother.vaccinations');

        Route::get('/mother/health-tips', [HealthTipController::class, 'index'])
            ->name('mother.health-tips');

        Route::get('/mother/health-tips/{healthTip}', [HealthTipController::class, 'show'])
            ->name('mother.health-tips.show');

        Route::get('/mother/growth-monitoring/{growthMonitoring}', [MotherGrowthMonitoringController::class, 'show'])
            ->name('mother.growth-monitoring.show');

        Route::get('/mother/privacy-notice', function () {
            return view('mother.privacy-notice');
        })->name('mother.privacy-notice');

        Route::post('/mother/privacy-consent', function () {
            $mother = auth()->user()->mother;

            $mother->update([
                'privacy_consent' => true,
                'privacy_consent_at' => now(),
            ]);

            return redirect()->route('mother.dashboard')
                ->with('success', 'Privacy consent recorded.');
        })->name('mother.privacy-consent');

    });






    
/*
|--------------------------------------------------------------------------
| Privacy Consent
|--------------------------------------------------------------------------
*/

Route::get('/privacy-consent', [PrivacyConsentController::class, 'show'])
    ->name('privacy.consent');

Route::post('/privacy-consent', [PrivacyConsentController::class, 'accept'])
    ->name('privacy.consent.accept');

Route::post('/privacy-consent/cancel', [PrivacyConsentController::class, 'cancel'])
    ->name('privacy.consent.cancel');


/*
|--------------------------------------------------------------------------
| Staff Confidentiality Acknowledgment
|--------------------------------------------------------------------------
*/

Route::get('/staff/confidentiality', [
    StaffConfidentialityController::class,
    'show',
])->name('staff.confidentiality.show');

Route::post('/staff/confidentiality/accept', [
    StaffConfidentialityController::class,
    'accept',
])->name('staff.confidentiality.accept');

}); // Closes outer Route::middleware(['auth']) group










/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD — EMAIL / SMS OTP (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])
        ->name('password.request');

    // Send OTP through Email
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.send-otp');

    // Send OTP through SMS
    Route::post('/forgot-password/sms', [ForgotPasswordController::class, 'sendSmsOtp'])
        ->name('password.send-sms-otp');

    // OTP Verification Page
    Route::get('/forgot-password/verify', function () {
        return view('auth.verify-otp');
    })->name('password.otp');

    // Verify OTP
    Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])
        ->name('password.verify-otp');

    // Reset Password Page
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPassword'])
        ->name('password.reset');

    // Update Password
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.update');

});


require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/

Route::get('/test-sms', function (TextBeeService $textBee) {

    $result = $textBee->send(
        '+639925519539',
        'Hello! This is a test SMS from CareCradle 🚀'
    );

    dd($result);
});