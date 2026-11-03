<?php


namespace App\Http\Controllers\Midwife;




use App\Http\Controllers\Controller;
use App\Models\Infant;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MidwifeInfantPhotoController extends Controller
{
    /**
     * Display an infant's privately stored photo to authorized Midwives.
     */
   
public function show(Infant $infant)
{
    // Ensure the infant has an associated mother.
    abort_unless($infant->mother()->exists(), 404);

    abort_unless($infant->photo_path, 404, 'No photo found.');

    $disk = Storage::disk('local');

    abort_unless($disk->exists($infant->photo_path), 404);

    $contents = $disk->get($infant->photo_path);

    // Validate the stored image as a JPEG.
    if (
        strlen($contents) < 4 ||
        substr($contents, 0, 3) !== "\xFF\xD8\xFF"
    ) {
        abort(415, 'The stored photo is not a valid JPEG image.');
    }

    $contentType = $disk->mimeType($infant->photo_path)
        ?: 'application/octet-stream';

    // Remove only the unwanted newline before the image response.
    $pendingOutput = ob_get_contents();

    if ($pendingOutput === "\n") {
        ob_clean();
    }

    return response()->stream(function () use ($contents): void {
        echo $contents;
    }, 200, [
        'Content-Type' => $contentType,
        'Cache-Control' => 'private, no-store, max-age=0',
        'X-Content-Type-Options' => 'nosniff',
    ]);
}

}