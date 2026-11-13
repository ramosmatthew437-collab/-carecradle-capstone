<?php

namespace App\Http\Controllers\Mother;





use App\Http\Controllers\Controller;
use App\Models\Infant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;





class MotherInfantPhotoController extends Controller
{
    /**
     * Upload or replace a photo for an infant owned by the logged-in mother.
     */
    public function update(Request $request, Infant $infant): RedirectResponse
    {
        $mother = $request->user()?->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        abort_unless(
            (int) $infant->mother_id === (int) $mother->id,
            404
        );

        $validated = $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'photo.required' => 'Please choose a baby photo to upload.',
            'photo.image' => 'Please upload a valid image.',
            'photo.mimes' => 'The photo must be JPG, JPEG, PNG, or WebP.',
            'photo.max' => 'The photo must not exceed 2 MB.',
        ]);

        $disk = Storage::disk('local');
        $oldPhotoPath = $infant->photo_path;

        $newPhotoPath = $validated['photo']->store(
            'infant-photos',
            'local'
        );

        if (!$newPhotoPath) {
            throw ValidationException::withMessages([
                'photo' => 'The photo could not be saved. Please try again.',
            ]);
        }

        $infant->photo_path = $newPhotoPath;
        $infant->save();

        if ($oldPhotoPath) {
            $disk->delete($oldPhotoPath);
        }

        return redirect()
            ->route('mother.infant-records', [
                'infant' => $infant->id,
            ])
            ->with(
                'success',
                'Your baby’s photo has been updated successfully.'
            );
    }

/**
 * Display a private infant photo after verifying ownership.
 */
public function show(Request $request, Infant $infant)
{
    $mother = $request->user()?->mother;

    abort_unless($mother, 404, 'Mother profile not found.');

    abort_unless(
        (int) $infant->mother_id === (int) $mother->id,
        404
    );

    abort_unless($infant->photo_path, 404, 'No photo found.');

    $disk = Storage::disk('local');

    abort_unless($disk->exists($infant->photo_path), 404);

    $contents = $disk->get($infant->photo_path);

    // Uploads accept JPG, PNG, and WebP, so identify the stored image
    // from its bytes (not its extension) and serve the matching type.
    $contentType = match (true) {
        str_starts_with($contents, "\xFF\xD8\xFF") => 'image/jpeg',
        str_starts_with($contents, "\x89PNG\r\n\x1A\n") => 'image/png',
        strlen($contents) >= 12
            && substr($contents, 0, 4) === 'RIFF'
            && substr($contents, 8, 4) === 'WEBP' => 'image/webp',
        default => null,
    };

    abort_unless($contentType, 415, 'The stored photo is not a supported image.');

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

    /**
     * Remove a photo for an infant owned by the logged-in mother.
     */
    public function destroy(
        Request $request,
        Infant $infant
    ): RedirectResponse {
        $mother = $request->user()?->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        abort_unless(
            (int) $infant->mother_id === (int) $mother->id,
            404
        );

        if ($infant->photo_path) {
            Storage::disk('local')->delete($infant->photo_path);

            $infant->photo_path = null;
            $infant->save();
        }

        return redirect()
            ->route('mother.infant-records', [
                'infant' => $infant->id,
            ])
            ->with(
                'success',
                'Your baby’s photo has been removed.'
            );
    }
}