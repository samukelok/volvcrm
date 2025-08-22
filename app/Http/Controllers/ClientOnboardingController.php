<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\SMTPSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\CpanelService;

class ClientOnboardingController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $client = $user->client;

        return view('client.onboarding', compact('user', 'client'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->client_id) {
            return redirect()->route('client')->with('info', 'You already have a client.');
        }

        $request->validate([
            'brand_name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'branding' => 'nullable|string',
            'company_email' => 'nullable|email|max:255'
        ]);

        try {
            // 1. Generate a clean base subdomain
            $baseSubdomain = strtolower(preg_replace('/[^a-z0-9]+/', '', $request->brand_name));
            $subdomain = $baseSubdomain;
            $counter = 1;

            while (Client::where('subdomain', $subdomain)->exists()) {
                $subdomain = $baseSubdomain . $counter;
                $counter++;
            }

            // 2. Create client
            $client = Client::create([
                'brand_name' => $request->brand_name,
                'website' => $request->website,
                'company_email' => $request->company_email,
                'branding' => $request->branding,
                'subdomain' => $subdomain,
                'status' => 'pending',
                'user_id' => $user->id,
            ]);

            // 3. Link client to user
            $user->update(['client_id' => $client->id]);

            // 4. Assign fallback SMTP to client automatically if none exists
            $fallbackSmtp = SMTPSetting::where('fallback', operator: true)->first();
            if ($fallbackSmtp) {
                // Duplicate fallback SMTP for this client
                $client->smtpSetting()->create([
                    'name' => $fallbackSmtp->name,
                    'host' => $fallbackSmtp->host,
                    'port' => $fallbackSmtp->port,
                    'username' => $fallbackSmtp->username,
                    'password' => $fallbackSmtp->password,
                    'encryption' => $fallbackSmtp->encryption,
                    'fallback' => false, 
                ]);
            }

            // 5. Redirect to client dashboard
            return redirect()->route('client')->with('success', 'Welcome to VolvCRM!');
        } catch (\Exception $e) {
            Log::error('Client creation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Client creation failed: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $client = $user->client;

        if (!$client) {
            return redirect()->route('client.onboarding')->with('error', 'You need to onboard first.');
        }

        $request->validate([
            'brand_name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'branding' => 'nullable|string',
            'company_email' => 'nullable|email|max:255'
        ]);

        try {
            $client->update($request->only(['brand_name', 'website', 'branding', 'company_email']));
            return redirect()->route('client')->with('success', 'Client details updated successfully!');
        } catch (\Exception $e) {
            Log::error('Client update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Client update failed: ' . $e->getMessage());
        }
    }
}
