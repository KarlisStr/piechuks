<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\Profesionali;
use App\Models\Klienti;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profileData = $user->is_professional ? $user->profesionali : $user->klienti;
        return view('profile', compact('user', 'profileData'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profileData = $user->is_professional ? $user->profesionali : $user->klienti;

        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telefons' => 'nullable|string|max:50',
            'bankas_konts' => 'nullable|string|max:50',
        ]);

        if ($user->is_professional) {
            $profileData->telefons = $request->input('telefons');
            $profileData->bankas_konts = $request->input('bankas_konts');
            $profileData->save();
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $path = $image->store('profile_images', 'public');

            // Save the image path to the images table
            $imageModel = new Image();
            $imageModel->imageable_id = $user->id;
            $imageModel->imageable_type = 'App\Models\User';
            $imageModel->image_path = $path;
            $imageModel->save();

            // Optionally, delete the old profile image if it exists
            if ($user->profileImage) {
                Storage::disk('public')->delete($user->profileImage->image_path);
                $user->profileImage->delete();
            }
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
