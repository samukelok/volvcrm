<?php

namespace App\Http\Controllers;

use App\Models\SMTPSetting;
use Illuminate\Http\Request;

class SMTPSettingController extends Controller
{
    /**
     * Display the client's SMTP setting
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        $smtp = $user->client->smtpSetting;
        if (!$smtp) {
            return response()->json(['message' => 'No SMTP setting found'], 404);
        }

        return response()->json($smtp);
    }

    /**
     * Show the form for creating a new SMTP setting (optional for API)
     */
    public function create()
    {
        return response()->json(['message' => 'Use store endpoint to create SMTP'], 200);
    }

    /**
     * Store a new SMTP setting for the client
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['error' => 'Not authenticated'], 401);
        if (!$user->client) return response()->json(['error' => 'User has no associated client'], 400);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'host'       => 'required|string|max:255',
            'port'       => 'required|integer',
            'username'   => 'required|string|max:255',
            'password'   => 'required|string|max:255',
            'encryption' => 'nullable|string|in:tls,ssl,null',
        ]);

        $smtp = $user->client->smtpSetting()->updateOrCreate(
            ['client_id' => $user->client->id],
            $validated
        );

        return response()->json(['message' => 'SMTP setting saved', 'smtp' => $smtp]);
    }

    /**
     * Display a specific SMTP setting
     */
    public function show(SMTPSetting $smtpSetting)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['error' => 'Not authenticated'], 401);
        if (!$user->client) return response()->json(['error' => 'User has no associated client'], 400);

        if ($smtpSetting->client_id !== $user->client->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($smtpSetting);
    }

    /**
     * Show form for editing SMTP (optional)
     */
    public function edit(SMTPSetting $smtpSetting)
    {
        return $this->show($smtpSetting);
    }

    /**
     * Update a client's SMTP setting
     */
    public function update(Request $request, SMTPSetting $smtpSetting)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['error' => 'Not authenticated'], 401);
        if (!$user->client) return response()->json(['error' => 'User has no associated client'], 400);

        if ($smtpSetting->client_id !== $user->client->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'host'       => 'required|string|max:255',
            'port'       => 'required|integer',
            'username'   => 'required|string|max:255',
            'password'   => 'required|string|max:255',
            'encryption' => 'nullable|string|in:tls,ssl,null',
        ]);

        $smtpSetting->update($validated);

        return response()->json(['message' => 'SMTP updated', 'smtp' => $smtpSetting]);
    }

    /**
     * Remove a client's SMTP setting
     */
    public function destroy(SMTPSetting $smtpSetting)
    {
        $user = auth()->user();
        if (!$user) return response()->json(['error' => 'Not authenticated'], 401);
        if (!$user->client) return response()->json(['error' => 'User has no associated client'], 400);

        if ($smtpSetting->client_id !== $user->client->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $smtpSetting->delete();

        return response()->json(['message' => 'SMTP setting deleted']);
    }
}
