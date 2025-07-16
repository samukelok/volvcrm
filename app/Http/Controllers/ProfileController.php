<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        // Generate public URL to send back
        $avatarUrl = $user->avatar ? Storage::url($user->avatar) : null;

        return response()->json([
            'flash' => 'Profile updated successfully!',
            'avatar' => $avatarUrl,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            $user = User::find(Auth::id());
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }

    public function updateName(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            $user = User::find(Auth::id());
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Name updated successfully!');
    }
}
