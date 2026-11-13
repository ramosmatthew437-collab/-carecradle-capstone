<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Appointment reminders: one run at a time (overlap lock), one server only.
// Each notification is also claimed atomically, so overlapping runs or a
// Midwife sending at the same moment cannot send the same reminder twice.
// --scheduled marks these runs as scheduler-triggered for the reminder monitor.
Schedule::command('app:send-appointment-reminders --scheduled')
    ->dailyAt('08:00')
    ->timezone('Asia/Manila')
    ->withoutOverlapping(30)
    ->onOneServer();

// Interrupted sends -> Unknown (for review) and read-only TextBee status checks.
Schedule::command('sms:reconcile --check-status')
    ->everyFifteenMinutes()
    ->withoutOverlapping(10)
    ->onOneServer();
