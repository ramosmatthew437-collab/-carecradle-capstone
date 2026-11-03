<?php

namespace App\Http\Controllers\Mother;


use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MotherProfileController extends Controller
{
    /**
     * Display the mother's profile.
     */
    public function index(): View
    {
        $mother = auth()->user()->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        return view('mother.profile', compact('mother'));
    }

    /**
     * Upload or replace the mother's profile photo.
     */
    public function updateProfilePhoto(Request $request): RedirectResponse
    {
        $mother = $request->user()->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        $validated = $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'profile_photo.required' => 'Please choose a photo to upload.',
            'profile_photo.image' => 'Please upload a valid image.',
            'profile_photo.mimes' => 'Your photo must be JPG, JPEG, PNG, or WebP.',
            'profile_photo.max' => 'Your photo must not exceed 2 MB.',
        ]);

        $oldPhoto = $mother->profile_photo_path;

        $newPhotoPath = $validated['profile_photo']->store(
            'mother-profile-photos',
            'public'
        );

        if (!$newPhotoPath) {
            throw ValidationException::withMessages([
                'profile_photo' => 'The photo could not be saved. Please try again.',
            ]);
        }

        $mother->profile_photo_path = $newPhotoPath;
        $mother->save();

        if ($oldPhoto) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()
            ->route('mother.profile')
            ->with('success', 'Your profile photo has been updated successfully.');
    }

    /**
     * Remove the mother's profile photo.
     */
    public function removeProfilePhoto(Request $request): RedirectResponse
    {
        $mother = $request->user()->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        if ($mother->profile_photo_path) {
            Storage::disk('public')->delete($mother->profile_photo_path);

            $mother->profile_photo_path = null;
            $mother->save();
        }

        return redirect()
            ->route('mother.profile')
            ->with('success', 'Your profile photo has been removed.');
    }
}