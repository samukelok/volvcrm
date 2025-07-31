<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatusChange;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index()
    {
        return Lead::with('statusChanges')->latest()->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'niche_category' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:25',
            'funnel_id' => 'nullable|exists:funnels,id',
            'source' => 'required|string',
            'source_type' => 'nullable|in:organic,ads,referral,manual',
            'status' => 'nullable|in:new,contacted,qualified,converted',
            'pays' => 'nullable|numeric',
            'client_id' => 'nullable|exists:clients,id',
            'lead_belongs_to' => 'nullable|array',
            'metadata' => 'nullable|array',
            'notes' => 'nullable|string',
            'contacted_at' => 'nullable|date',
            'converted_at' => 'nullable|date',
            'is_test' => 'boolean'
        ]);

        $lead = Lead::create($validated);

        return response()->json($lead, 201);
    }

    public function show(Lead $lead)
    {
        return $lead->load('statusChanges');
    }

    public function edit(Lead $lead)
    {
        //
    }

    public function update(Request $request, Lead $lead)
    {
        $oldStatus = $lead->status;

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'niche_category' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string|max:25',
            'funnel_id' => 'nullable|exists:funnels,id',
            'source' => 'sometimes|string',
            'source_type' => 'nullable|in:organic,ads,referral,manual',
            'status' => 'sometimes|in:new,contacted,qualified,converted',
            'pays' => 'nullable|numeric',
            'client_id' => 'nullable|exists:clients,id',
            'lead_belongs_to' => 'nullable|array',
            'metadata' => 'nullable|array',
            'notes' => 'nullable|string',
            'contacted_at' => 'nullable|date',
            'converted_at' => 'nullable|date',
            'is_test' => 'boolean'
        ]);

        $lead->update($validated);

        if (isset($validated['status']) && $validated['status'] !== $oldStatus) {
            LeadStatusChange::create([
                'lead_id' => $lead->id,
                'from_status' => $oldStatus,
                'to_status' => $validated['status'],
                'user_id' => auth()->id(),
                'changed_at' => now(),
            ]);
        }

        return response()->json($lead);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json(['message' => 'Lead deleted.']);
    }
}
