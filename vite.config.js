
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/carecradle.css',
                'resources/css/mother-management.css',
                'resources/css/mother-profile.css',
                'resources/css/mother-edit.css',
                'resources/css/sms-notifications.css',
                'resources/css/sms-notification-show.css',
                'resources/css/prenatal-visit-show.css',
                'resources/css/prenatal-create.css',
                'resources/css/prenatal-visit-edit.css',
                'resources/css/appointment-details.css',
                'resources/css/appointment-edit.css',
                'resources/css/carecradle-background.css',
                'resources/css/midwife-management.css',
                'resources/css/admin-foundation.css',
                'resources/css/admin-dashboard.css',
                'resources/css/activity-logs.css',
                'resources/css/midwife-foundation.css',
                'resources/css/midwife-dashboard.css',
                'resources/css/health-tips-management.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
