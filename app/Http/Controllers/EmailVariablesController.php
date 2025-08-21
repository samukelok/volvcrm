<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailVariablesController extends Controller
{
    public function clientEmailVariables(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        return response()->json([
            'company_name'=> $user->client->brand_name,

            // I will add more variables later:
            //Namely: Unsubscribe link | Lead_Name
        ]);
    }
}
