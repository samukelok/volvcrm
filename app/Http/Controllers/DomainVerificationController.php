<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Dns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainVerificationController extends Controller{

public function verify(Request $request)
{
    $client = Auth::user()->client;

    $records = dns_get_record(parse_url($client->website, PHP_URL_HOST), DNS_TXT);

    $verified = collect($records)->contains(function ($record) {
        return str_contains($record['txt'], 'volv-verification=verified');
    });

    if ($verified) {
        $client->update(['status' => 'verified']);
        return redirect()->route('dashboard')->with('success', 'Domain verified! You can now use all features.');
    }

    return back()->with('error', 'Verification failed. Please add the TXT record and try again.');
}
}