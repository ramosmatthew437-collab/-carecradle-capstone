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
use App\Http\Controllers\Mother\MotherPrintRecordsController;
use App\Http\Controllers\Mother\MotherGrowthMonitoringController;
use App\Http\Controllers\Mother\MotherVaccinationController;
use App\Http\Controllers\HealthTipController;
use App\Http\Controllers\MidwifeHealthTipController;
use App\Http\Middleware\EnsurePrivacyConsent;
use App\Http\Controllers\PrivacyConsentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StaffConfidentialityController;
use App\Http\Controllers\PrenatalCheckupAttachmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public landing page (previously redirected straight to /login).
Route::view('/', 'welcome')->name('home');


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

        // RHU Patient Records Center (read-only, GET only).
        // Administrators can search, view, print, and export; they cannot create, edit, or delete.
        Route::get('/reports/patients', [\App\Http\Controllers\Admin\PatientRecordController::class, 'index'])
            ->name('reports.patients.index');

        Route::get('/reports/patients/{mother}', [\App\Http\Controllers\Admin\PatientRecordController::class, 'show'])
            ->whereNumber('mother')
            ->name('reports.patients.show');

        Route::get('/reports/patients/{mother}/print', [\App\Http\Controllers\Admin\PatientRecordController::class, 'print'])
            ->whereNumber('mother')
            ->name('reports.patients.print');

        Route::get('/reports/patients/{mother}/pdf', [\App\Http\Controllers\Admin\PatientRecordController::class, 'pdf'])
            ->whereNumber('mother')
            ->name('reports.patients.pdf');

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


    // Midwife Profile Photo
    Route::post('/midwife/profile/photo', [
        \App\Http\Controllers\Midwife\MidwifeProfilePhotoController::class,
        'update',
    ])->name('midwife.profile-photo.update');

    Route::delete('/midwife/profile/photo', [
        \App\Http\Controllers\Midwife\MidwifeProfilePhotoController::class,
        'destroy',
    ])->name('midwife.profile-photo.destroy');

        Route::resource('midwife/health-tips', MidwifeHealthTipController::class)
            ->names('midwife.health-tips');

        Route::get('/test-midwife', function () {
            return view('test-midwife');
        });

        // Read-only infant photo display for Midwives
Route::get('/midwife/infants/{infant}/photo', [
    \App\Http\Controllers\Midwife\MidwifeInfantPhotoController::class,
    'show',
])->name('midwife.infant-photo.show');



        // Maternal Vaccinations
Route::get(
    '/midwife/mothers/{mother}/vaccinations/create',
    [\App\Http\Controllers\Midwife\MaternalVaccinationController::class, 'create']
)->name('midwife.maternal-vaccinations.create');

Route::post(
    '/midwife/mothers/{mother}/vaccinations',
    [\App\Http\Controllers\Midwife\MaternalVaccinationController::class, 'store']
)->name('midwife.maternal-vaccinations.store');

Route::get(
    '/midwife/mothers/{mother}/vaccinations/{vaccination}/edit',
    [\App\Http\Controllers\Midwife\MaternalVaccinationController::class, 'edit']
)->name('midwife.maternal-vaccinations.edit');

Route::put(
    '/midwife/mothers/{mother}/vaccinations/{vaccination}',
    [\App\Http\Controllers\Midwife\MaternalVaccinationController::class, 'update']
)->name('midwife.maternal-vaccinations.update');

Route::delete(
    '/midwife/mothers/{mother}/vaccinations/{vaccination}',
    [\App\Http\Controllers\Midwife\MaternalVaccinationController::class, 'destroy']
)->name('midwife.maternal-vaccinations.destroy');

        /*
        |--------------------------------------------------------------------------
        | Mother Management
        |--------------------------------------------------------------------------
        */

        Route::resource('mothers', MotherController::class);

        /*
        |--------------------------------------------------------------------------
        | Mother Referrals (Midwife). Administrators see referrals read-only
        | on the patient record. Referrals are never deleted.
        |--------------------------------------------------------------------------
        */

        Route::get('/mothers/{mother}/referrals/create', [\App\Http\Controllers\MotherReferralController::class, 'create'])
            ->name('referrals.create');
        Route::post('/mothers/{mother}/referrals', [\App\Http\Controllers\MotherReferralController::class, 'store'])
            ->name('referrals.store');
        Route::get('/referrals/{referral}/edit', [\App\Http\Controllers\MotherReferralController::class, 'edit'])
            ->name('referrals.edit');
        Route::put('/referrals/{referral}', [\App\Http\Controllers\MotherReferralController::class, 'update'])
            ->name('referrals.update');
        Route::post('/referrals/{referral}/close', [\App\Http\Controllers\MotherReferralController::class, 'close'])
            ->name('referrals.close');
        Route::post('/referrals/{referral}/void', [\App\Http\Controllers\MotherReferralController::class, 'void'])
            ->name('referrals.void');

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


    // Prenatal Laboratory Attachments
Route::get(
    '/prenatal-attachments/{attachment}/download',
    [PrenatalCheckupAttachmentController::class, 'downloadForMidwife']
)->name('midwife.prenatal-attachments.download');

Route::get(
    '/prenatal-attachments/{attachment}/preview',
    [PrenatalCheckupAttachmentController::class, 'previewForMidwife']
)->name('midwife.prenatal-attachments.preview');

Route::delete(
    '/prenatal-attachments/{attachment}',
    [PrenatalCheckupAttachmentController::class, 'destroy']
)->name('midwife.prenatal-attachments.destroy');

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

        Route::get('/sms-notifications/scheduler-runs',
            [\App\Http\Controllers\SmsNotificationController::class, 'schedulerRuns'])
            ->name('sms-notifications.scheduler-runs');

        Route::get('/sms-notifications/{smsNotification}',
            [\App\Http\Controllers\SmsNotificationController::class, 'show'])
            ->name('sms-notifications.show');

        Route::post('/sms-notifications/{smsNotification}/send', [SmsNotificationController::class, 'send'])
            ->name('sms-notifications.send');

        Route::post('/sms-notifications/{smsNotification}/retry', [SmsNotificationController::class, 'retry'])
            ->name('sms-notifications.retry');

        Route::post('/sms-notifications/{smsNotification}/review', [SmsNotificationController::class, 'review'])
            ->name('sms-notifications.review');

        Route::post('/sms-notifications/{smsNotification}/check-status', [SmsNotificationController::class, 'checkStatus'])
            ->name('sms-notifications.check-status');

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
        // Read-only list of the signed-in mother's own referrals (no IDs in the URL).
        Route::get('/mother/referrals', [\App\Http\Controllers\Mother\MotherReferralController::class, 'index'])
            ->name('mother.referrals');

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

            Route::get('/mother/print-records', [MotherPrintRecordsController::class, 'index'])
    ->name('mother.print-records');



    Route::post('/mother/profile/photo', [
    \App\Http\Controllers\Mother\MotherProfileController::class,
    'updateProfilePhoto',
])->name('mother.profile.photo.update');

Route::delete('/mother/profile/photo', [
    \App\Http\Controllers\Mother\MotherProfileController::class,
    'removeProfilePhoto',
])->name('mother.profile.photo.remove');

       Route::get('/mother/privacy-notice', function () {
    return view('privacy.consent');
})->name('mother.privacy-notice');


// Mother Prenatal Laboratory Attachments
Route::get(
    '/mother/prenatal-attachments/{attachment}/download',
    [PrenatalCheckupAttachmentController::class, 'downloadForMother']
)->name('mother.prenatal-attachments.download');


Route::get(
    '/mother/prenatal-attachments/{attachment}/preview',
    [PrenatalCheckupAttachmentController::class, 'previewForMother']
)->name('mother.prenatal-attachments.preview');




        // Mother-only infant photo management
        Route::post('/mother/infants/{infant}/photo', [
            \App\Http\Controllers\Mother\MotherInfantPhotoController::class,
            'update',
        ])->name('mother.infant-photo.update');

        Route::get('/mother/infants/{infant}/photo', [
            \App\Http\Controllers\Mother\MotherInfantPhotoController::class,
            'show',
        ])->name('mother.infant-photo.show');

        Route::delete('/mother/infants/{infant}/photo', [
            \App\Http\Controllers\Mother\MotherInfantPhotoController::class,
            'destroy',
        ])->name('mother.infant-photo.destroy');


        Route::post('/mother/privacy-consent', function () {
            $mother = \Illuminate\Support\Facades\Auth::user()?->mother;

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


Route::post('/staff/confidentiality/cancel', [
    StaffConfidentialityController::class,
    'cancel',
])->name('staff.confidentiality.cancel');











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
