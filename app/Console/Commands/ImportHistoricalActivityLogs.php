<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportHistoricalActivityLogs extends Command
{
    protected $signature = 'activity-logs:backfill
                            {--dry-run : Preview records without importing them}';

    protected $description = 'Import existing CareCradle records into the activity log as historical entries';

    public function handle(): int
    {
        $sources = [
            'mothers' => 'Mother Management',
            'infants' => 'Infant Management',
            'appointments' => 'Appointment Management',
            'prenatal_checkups' => 'Prenatal Checkups',
            'growth_monitorings' => 'Growth Monitoring',
            'medical_logs' => 'Medical Records',
            'vaccinations' => 'Vaccination Management',
            'sms_notifications' => 'SMS Notifications',
        ];

        $dryRun = $this->option('dry-run');
        $totalPlanned = 0;
        $totalImported = 0;
        $totalSkipped = 0;

        $this->info($dryRun
            ? 'DRY RUN: No database records will be inserted.'
            : 'Starting historical activity-log backfill...'
        );

        foreach ($sources as $table => $module) {
            $sourceCount = 0;
            $importedCount = 0;
            $skippedCount = 0;

            DB::table($table)
                ->select(['id', 'created_at'])
                ->orderBy('id')
                ->chunkById(200, function ($records) use (
                    $table,
                    $module,
                    $dryRun,
                    &$sourceCount,
                    &$importedCount,
                    &$skippedCount
                ) {
                    foreach ($records as $record) {
                        $sourceCount++;

                        $alreadyImported = DB::table('activity_logs')
                            ->where('source_table', $table)
                            ->where('source_record_id', $record->id)
                            ->exists();

                        if ($alreadyImported) {
                            $skippedCount++;
                            continue;
                        }

                        if ($dryRun) {
                            $importedCount++;
                            continue;
                        }

                        $createdAt = $record->created_at ?: now();

                        $description = "Historical import of existing {$module} record #{$record->id}. "
                            . ($record->created_at
                                ? "Original record creation timestamp: {$record->created_at}. "
                                : 'Original creation timestamp unavailable; import time used instead. ')
                            . 'The original data-entry user was not established by this import.';

                        // Preserve the recorded administrator field separately
                        // from the user who originally entered the record.
                        if ($table === 'vaccinations') {
                            $administeredBy = DB::table('vaccinations')
                                ->where('id', $record->id)
                                ->value('administered_by');

                            if ($administeredBy) {
                                $description .= " Recorded administered-by value: {$administeredBy}.";
                            }
                        }

                        $inserted = DB::table('activity_logs')->insertOrIgnore([
                            'user_id' => null,
                            'actor_name' => 'Unknown / Historical Import',
                            'actor_username' => null,
                            'action' => 'historical_import',
                            'module' => $module,
                            'record_id' => $record->id,
                            'description' => $description,
                            'ip_address' => null,
                            'user_agent' => null,
                            'source_table' => $table,
                            'source_record_id' => $record->id,
                            'created_at' => $createdAt,
                            'updated_at' => now(),
                        ]);

                        if ($inserted > 0) {
                            $importedCount++;
                        } else {
                            // Another import may have inserted this record
                            // or a database constraint prevented insertion.
                            $skippedCount++;
                        }
                    }
                });

            $totalPlanned += $importedCount;
            $totalImported += $importedCount;
            $totalSkipped += $skippedCount;

            $this->line(sprintf(
                '%s: %d source records; %d %s; %d already imported/skipped.',
                $module,
                $sourceCount,
                $importedCount,
                $dryRun ? 'would be imported' : 'imported',
                $skippedCount
            ));
        }

        $this->newLine();

        if ($dryRun) {
            $this->info("Dry run complete. {$totalPlanned} records are ready for import.");
            $this->comment('No activity-log records were inserted.');
        } else {
            $this->info("Backfill complete. {$totalImported} historical entries imported.");
            $this->comment("{$totalSkipped} records were already imported or skipped.");
        }

        return self::SUCCESS;
    }
}