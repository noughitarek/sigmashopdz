<?php

namespace App\Http\Controllers\webmaster;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $data["title"] = 'Profile';
        $data["user"] = Auth::user();
        return view("webmaster.settings.profile")->with("data", $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        
        $request->user()->phone = $request->phone;
        $request->user()->phone2 = $request->phone2;

        if($request->has('profile_image')){
            $photoName = time() . '_' . $request->profile_image->getClientOriginalName();
            $request->profile_image->move(public_path('img/avatars'), $photoName);
            $request->user()->profile_image = $photoName;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        return redirect()->route('webmaster_profile_index')->with('success', 'Profile updated successfully');
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

    
    /**
     * Update the user's password.
     */
    public function password_edit(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        $request->user()->invalidateSessions();

        return redirect()->route('webmaster_profile_index')->with('success', 'Password updated successfully');
    }
}
