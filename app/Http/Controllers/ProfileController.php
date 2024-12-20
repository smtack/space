<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return Inertia::render('Profile/Index', [
            'profile' => $user,
            'posts' => Post::with('user:id,name,username,avatar')->where('user_id', '=', $user->id)->latest()->get(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Update the users bio
     */
    public function bio(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bio' => 'required|min:3|max:255',
        ]);

        $request->user()->update($validated);

        return Redirect::route('profile.edit');
    }

    public function avatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $request->file('avatar')->store('avatars', 'public');

        $filename = $request->avatar->hashName();

        if(Auth::user()->avatar !== 'default.webp') {
            $path = 'storage/avatars/' . Auth::user()->avatar;

            if(File::exists($path)) {
                File::delete($path);
            }
        }

        $request->user()->update([
            'avatar' => $filename,
        ]);

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
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
