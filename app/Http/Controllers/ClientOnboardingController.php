<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            'brand_name' => 'required',
            'website' => 'nullable|url',
            'branding' => 'nullable|string',
        ]);

        try {

            $client = Client::create([
                'brand_name' => $request->brand_name,
                'website' => $request->website,
                'branding' => $request->branding,
                'status' => 'pending',
                'created_by' => $user->id, 
            ]);

            $user->update(['client_id' => $client->id]);

            return redirect()->route('dashboard')->with('success', 'Welcome To VolvCRM.');
        } catch (\Exception $e) {
            logger()->error('Client creation failed:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Client creation failed: ' . $e->getMessage());
        }
    }
}