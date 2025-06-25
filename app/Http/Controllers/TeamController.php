<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamInvitation;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function invite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name'
        ]);

        $client = \Illuminate\Support\Facades\Auth::user()->client;

        if (!$client) {
            return back()->with('error', 'You are not associated with any client.');
        }

        $token = Str::random(40);

        // Store invitation
        $client->invitations()->create([
            'email' => $request->email,
            'token' => $token,
            'role' => $request->role,
            'expires_at' => now()->addDays(7)
        ]);

        // Send email
        Mail::to($request->email)->send(new TeamInvitation(
            \Illuminate\Support\Facades\Auth::user(),
            $client,
            $token,
            $request->role
        ));

        return back()->with('success', 'Invitation sent successfully!');
    }

    public function updateRole(User $user, Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        // Remove all current roles
        $user->roles()->detach();

        // Assign new role
        $role = Role::where('name', $request->role)->first();
        $user->roles()->attach($role);

        return back()->with('success', 'Role updated successfully!');
    }

    public function remove(User $user)
    {
        // Only allow removing team members from the same client
        if ($user->client_id !== request()->user()->client_id) {
            abort(403);
        }

        // Don't allow removing yourself
        if ($user->id === request()->user()->id) {

            return back()->with('error', 'You cannot remove yourself from the team.');
        }

        // Remove user from client (assuming you have a client_user pivot table)
        $user->client_id = null;
        $user->save();

        return back()->with('success', 'Team member removed successfully.');
    }
}
