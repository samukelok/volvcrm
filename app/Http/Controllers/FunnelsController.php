<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;

class FunnelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all funnels, eager load related user and client
        $funnels = Funnel::with(['user', 'client'])->get();

        return response()->json($funnels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'goal' => 'required|string',
            'target_audience' => 'required|string',
            'cta' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'deadline' => 'required|date',
            'user_id' => 'nullable|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'is_active' => 'boolean',
            'priority' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:100',
        ]);

        $funnel = Funnel::create($validated);

        return response()->json($funnel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Funnel $funnel)
    {
        // Eager load related user and client
        $funnel->load(['user', 'client']);

        return response()->json($funnel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Funnel $funnel)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'goal' => 'sometimes|required|string',
            'target_audience' => 'sometimes|required|string',
            'cta' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string',
            'deadline' => 'sometimes|required|date',
            'user_id' => 'nullable|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'is_active' => 'boolean',
            'priority' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:100',
        ]);

        $funnel->update($validated);

        return response()->json($funnel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Funnel $funnel)
    {
        $funnel->delete();

        return response()->json(null, 204);
    }
}
