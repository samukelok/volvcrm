<?php

namespace App\Http\Controllers;

use App\Models\LeadStatusChange;
use Illuminate\Http\Request;

class LeadsStatusChangeController extends Controller
{
    public function index()
    {
        return LeadStatusChange::with('lead', 'user')->latest()->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'from_status' => 'required|in:new,contacted,qualified,converted',
            'to_status' => 'required|in:new,contacted,qualified,converted',
            'user_id' => 'nullable|exists:users,id',
            'changed_at' => 'nullable|date'
        ]);

        $change = LeadStatusChange::create([
            ...$validated,
            'changed_at' => $validated['changed_at'] ?? now(),
        ]);

        return response()->json($change, 201);
    }

    public function show(LeadStatusChange $leadStatusChange)
    {
        return $leadStatusChange->load('lead', 'user');
    }

    public function edit(LeadStatusChange $leadStatusChange)
    {
        //
    }

    public function update(Request $request, LeadStatusChange $leadStatusChange)
    {
        $validated = $request->validate([
            'from_status' => 'sometimes|in:new,contacted,qualified,converted',
            'to_status' => 'sometimes|in:new,contacted,qualified,converted',
            'user_id' => 'nullable|exists:users,id',
            'changed_at' => 'nullable|date'
        ]);

        $leadStatusChange->update($validated);

        return response()->json($leadStatusChange);
    }

    public function destroy(LeadStatusChange $leadStatusChange)
    {
        $leadStatusChange->delete();
        return response()->json(['message' => 'Status change deleted.']);
    }
}
