<?php

namespace App\Http\Controllers;
use App\Models\PrenatalCheckupAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrenatalCheckupAttachmentController extends Controller
{
    /**
     * Download a laboratory attachment as a Midwife.
     */
    public function downloadForMidwife(
        PrenatalCheckupAttachment $attachment
    ) {
        abort_unless(
            Storage::disk('local')->exists($attachment->file_path),
            404
        );

        return Storage::disk('local')->download(
            $attachment->file_path,
            $attachment->file_name,
            [
                'Content-Type' => $attachment->mime_type,
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    /**
     * Download a laboratory attachment as its owning Mother.
     */
    public function downloadForMother(
        PrenatalCheckupAttachment $attachment
    ) {
        $mother = Auth::user()?->mother;

        abort_unless(
            $mother &&
            $attachment->prenatalCheckup()
                ->where('mother_id', $mother->id)
                ->exists(),
            404
        );

        abort_unless(
            Storage::disk('local')->exists($attachment->file_path),
            404
        );

        return Storage::disk('local')->download(
            $attachment->file_path,
            $attachment->file_name,
            [
                'Content-Type' => $attachment->mime_type,
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    /**
     * Delete a laboratory attachment as a Midwife.
     */
    public function destroy(
        PrenatalCheckupAttachment $attachment
    ) {
        Storage::disk('local')->delete($attachment->file_path);

        $attachment->delete();

        return back()->with(
            'success',
            'Laboratory document deleted successfully.'
        );
    }
/**
 * Display an image attachment inline for a Midwife.
 */
public function previewForMidwife(
    PrenatalCheckupAttachment $attachment
) {
    abort_unless(
        in_array(
            strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION)),
            ['jpg', 'jpeg', 'png']
        ),
        404
    );

    $disk = Storage::disk('local');

    abort_unless($disk->exists($attachment->file_path), 404);

    $path = $disk->path($attachment->file_path);

    return response()->file($path, [
        'Content-Type' => $attachment->mime_type,
        'Content-Disposition' => 'inline; filename="' . basename($attachment->file_name) . '"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'private, no-store',
    ]);
}

/**
 * Display an image attachment inline for its owning Mother.
 */
public function previewForMother(
    PrenatalCheckupAttachment $attachment
) {
    $mother = Auth::user()?->mother;

    abort_unless(
        $mother &&
        $attachment->prenatalCheckup()
            ->where('mother_id', $mother->id)
            ->exists(),
        404
    );

    abort_unless(
        in_array(
            strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION)),
            ['jpg', 'jpeg', 'png']
        ),
        404
    );

    $disk = Storage::disk('local');

    abort_unless($disk->exists($attachment->file_path), 404);

    return response()->file(
        $disk->path($attachment->file_path),
        [
            'Content-Type' => $attachment->mime_type,
            'Content-Disposition' => 'inline; filename="' . basename($attachment->file_name) . '"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store',
        ]
    );
}
}