<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientOnboardingController extends Controller
{
    public function show()
    {
        return view('client.onboarding');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
            'website' => 'required|url',
            'branding' => 'required|json',
        ]);

        $client = Client::create([
            'user_id' => Auth::id(),
            'brand_name' => $request->brand_name,
            'website' => $request->website,
            'branding' => $request->branding,
            'status' => 'pending',
        ]);

        // Associate user with client
        $user = Auth::user();
        $user->client_id = $client->id;
        $user->save();

        return redirect()->route('client.verify.domain');
    }
}