<?php

namespace App\Http\Requests;

use App\Models\PrenatalCheckup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class StorePrenatalCheckupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // A prenatal visit records a check-up that has taken place, so a new
            // or changed visit date may not be in the future. An existing visit
            // whose stored date is left unchanged can still be edited.
            'visit_date' => $this->visitDateUnchanged()
                ? ['required', 'date']
                : ['required', 'date', 'before_or_equal:today'],
            'gestational_age_weeks' => ['required', 'integer', 'min:1', 'max:42'],
            'weight' => ['required', 'numeric', 'min:1'],
            'systolic_bp' => ['required', 'integer', 'min:50', 'max:250'],
            'diastolic_bp' => ['required', 'integer', 'min:30', 'max:200'],
            'fundal_height' => ['nullable', 'numeric'],
            'fetal_heart_rate' => ['nullable', 'integer'],
            'fetal_movement' => ['nullable', 'in:Normal,Reduced,Not Yet Felt'],
            'urine_protein' => ['nullable', 'in:Negative,Trace,+1,+2,+3'],
            'urine_glucose' => ['nullable', 'in:Negative,Trace,+1,+2,+3'],
            'maternal_condition' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'next_visit_date' => ['nullable', 'date', 'after_or_equal:visit_date'],

            // Laboratory document attachments (optional): up to 10 files,
            // 10 MB each, 100 MB combined; PDF, JPG, JPEG, or PNG only.
            'laboratory_attachments' => [
                'nullable',
                'array',
                'max:' . self::LAB_MAX_FILES,
                function (string $attribute, mixed $files, \Closure $fail) {
                    if (self::totalUploadBytes($files) > self::LAB_MAX_TOTAL_BYTES) {
                        $fail('The selected laboratory documents total more than 100 MB. Please upload fewer or smaller files.');
                    }
                },
            ],
            'laboratory_attachments.*' => [
                'file',
                'extensions:' . implode(',', self::LAB_EXTENSIONS),
                'mimes:' . implode(',', self::LAB_EXTENSIONS),
                'max:' . self::LAB_MAX_FILE_KB,
            ],
        ];
    }

    /** Approved laboratory attachment limits (server-side, authoritative). */
    public const LAB_MAX_FILES = 10;

    public const LAB_MAX_FILE_KB = 10240; // 10 MB

    public const LAB_MAX_TOTAL_BYTES = 100 * 1024 * 1024; // 100 MB

    public const LAB_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png'];

    /**
     * Messages that name the offending file, so the form can list each
     * problem next to the upload control.
     */
    public function messages(): array
    {
        $messages = [
            'laboratory_attachments.array' => 'The laboratory documents could not be read. Please choose the files again.',
            'laboratory_attachments.max' => 'You can upload up to ' . self::LAB_MAX_FILES . ' laboratory documents at a time.',
        ];

        $files = $this->file('laboratory_attachments');

        foreach (is_array($files) ? $files : [] as $index => $file) {
            $name = $file instanceof UploadedFile ? $file->getClientOriginalName() : 'File ' . ((int) $index + 1);
            $key = "laboratory_attachments.{$index}";

            $messages["{$key}.uploaded"] = "\"{$name}\" could not be uploaded. It may be larger than the server currently accepts.";
            $messages["{$key}.file"] = "\"{$name}\" could not be uploaded.";
            $messages["{$key}.extensions"] = "\"{$name}\" is not a PDF, JPG, JPEG, or PNG file.";
            $messages["{$key}.mimes"] = "\"{$name}\" is not a PDF, JPG, JPEG, or PNG file.";
            $messages["{$key}.max"] = "\"{$name}\" is larger than 10 MB.";
        }

        return $messages;
    }

    /**
     * Combined size of the successfully uploaded files only (failed or
     * non-file entries are reported by their own rules).
     */
    public static function totalUploadBytes(mixed $files): int
    {
        if (! is_array($files)) {
            return 0;
        }

        $total = 0;

        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $total += (int) $file->getSize();
            }
        }

        return $total;
    }

    /**
     * Limits for the upload form: the approved limits, and the lower limits
     * of the running PHP configuration (which rejects larger uploads before
     * Laravel runs). The form enforces the stricter of the two.
     */
    public static function labUploadLimits(): array
    {
        $toBytes = function (string|false $value): ?int {
            $value = trim((string) $value);

            if ($value === '' || $value === '-1' || $value === '0') {
                return null; // unlimited
            }

            $number = (float) $value;

            return (int) match (strtolower(substr($value, -1))) {
                'g' => $number * 1024 ** 3,
                'm' => $number * 1024 ** 2,
                'k' => $number * 1024,
                default => $number,
            };
        };

        $approvedFile = self::LAB_MAX_FILE_KB * 1024;
        $serverFile = $toBytes(ini_get('upload_max_filesize'));
        $serverPost = $toBytes(ini_get('post_max_size'));
        $serverCount = (int) ini_get('max_file_uploads') ?: null;

        // Leave room for the visit's other form fields within post_max_size.
        $serverTotal = $serverPost === null ? null : max(0, $serverPost - 256 * 1024);

        return [
            'approved' => [
                'files' => self::LAB_MAX_FILES,
                'file_bytes' => $approvedFile,
                'total_bytes' => self::LAB_MAX_TOTAL_BYTES,
            ],
            'server' => [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_file_uploads' => ini_get('max_file_uploads'),
            ],
            'effective' => [
                'files' => min(self::LAB_MAX_FILES, $serverCount ?? PHP_INT_MAX),
                'file_bytes' => min($approvedFile, $serverFile ?? PHP_INT_MAX),
                'total_bytes' => min(self::LAB_MAX_TOTAL_BYTES, $serverTotal ?? PHP_INT_MAX),
            ],
            'extensions' => self::LAB_EXTENSIONS,
        ];
    }

    /**
     * True only when editing an existing visit and the submitted visit date
     * is the same calendar date as the one already stored.
     */
    private function visitDateUnchanged(): bool
    {
        $checkup = $this->route('prenatalCheckup');

        if (! $checkup instanceof PrenatalCheckup
            || blank($checkup->visit_date)
            || blank($this->input('visit_date'))) {
            return false;
        }

        try {
            return Carbon::parse($this->input('visit_date'))->toDateString()
                === Carbon::parse($checkup->visit_date)->toDateString();
        } catch (\Throwable) {
            return false;
        }
    }
}