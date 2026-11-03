<?php

namespace App\Http\Controllers\Midwife;




use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MidwifeProfilePhotoController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'profile_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $midwife = Auth::user();

        // Delete the previous profile photo, if one exists.
        if ($midwife->profile_photo_path) {
            Storage::disk('public')->delete($midwife->profile_photo_path);
        }

        // Store the new profile photo.
        $path = $request->file('profile_photo')
            ->store('midwife-profile-photos', 'public');

        $midwife->update([
            'profile_photo_path' => $path,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function destroy()
    {
        $midwife = Auth::user();

        if ($midwife->profile_photo_path) {
            Storage::disk('public')->delete($midwife->profile_photo_path);

            $midwife->update([
                'profile_photo_path' => null,
            ]);
        }

        return back()->with('success', 'Profile photo removed successfully.');
    }
}