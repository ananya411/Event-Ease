<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Fill only user fields
        $user->fill($request->safe()->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($user->role === 'vendor') {
            // Find or create the vendor profile associated with the user
            $vendor = Vendor::firstOrCreate(['user_id' => $user->_id]);

            $vendorData = [
                'name' => $user->name, // Keep names synchronized
                'vendor_type' => $request->input('vendor_type'),
                'city' => $request->input('city'),
                'price' => (int) $request->input('price'),
                'phone' => $request->input('phone'),
                'description' => $request->input('description'),
            ];

            if ($request->boolean('remove_image')) {
                if ($vendor->image) {
                    Storage::disk('public')->delete($vendor->image);
                }
                $vendorData['image'] = null;
            } elseif ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($vendor->image) {
                    Storage::disk('public')->delete($vendor->image);
                }

                // Store new image
                $path = $request->file('image')->store('banners', 'public');
                $vendorData['image'] = $path;
            }

            $vendor->update($vendorData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
