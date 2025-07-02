<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
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
            return redirect()->route('dashboard')->with('info', 'You already have a client.');
        }

        $request->validate([
            'brand_name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'branding' => 'nullable|string',
        ]);

        try {
            // 1. Generate a clean base subdomain
            $baseSubdomain = strtolower(preg_replace('/[^a-z0-9]+/', '', $request->brand_name));
            $subdomain = $baseSubdomain;
            $counter = 1;

            // 2. Ensure uniqueness
            while (Client::where('subdomain', $subdomain)->exists()) {
                $subdomain = $baseSubdomain . $counter;
                $counter++;
            }

            // 3. Create the client record
            $client = Client::create([
                'brand_name' => $request->brand_name,
                'website' => $request->website,
                'branding' => $request->branding,
                'subdomain' => $subdomain,
                'status' => 'pending',
                'created_by' => $user->id,
            ]);

            // 4. Link client to user
            $user->update(['client_id' => $client->id]);

            // 5. Create subdomain via cPanel
            $cpanel = new CpanelService();
            $cpanel->createSubdomain($subdomain);

            // 6. Redirect to new subdomain dashboard
            $dashboardUrl = "https://{$subdomain}.cyberkru.com/dashboard";
            return redirect()->away($dashboardUrl)->with('success', 'Welcome to VolvCRM!');

        } catch (\Exception $e) {
            Log::error('Client creation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Client creation failed: ' . $e->getMessage());
        }
    }
}
