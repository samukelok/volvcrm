<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        // Log raw incoming request data
        Log::info('Incoming funnel form data:', $request->all());
        Log::info('Incoming funnel form data:', $request->except('media'));
        Log::info('Media files:', $request->file('media'));

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
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp,pdf|max:10240', 
        ]);

        $validated['user_id'] = Auth::id();
        $validated['client_id'] = Auth::user()?->client?->id;

        $funnel = Funnel::create($validated);

        // Handle media uploads
       if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $filename = $file->store('funnel-media', 'public');

                $funnel->media()->create([
                    'file_path' => $filename,
                    'file_name' => $filename,
                ]);
            }
        }

       return response()->json([
            'flash' => 'Funnel sent successfully :)',
            'funnel' => $funnel->load('media'), 
        ]);
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

        return response()->json(['flash' => 'Funnel updated successfully :)']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Funnel $funnel)
    {
        $funnel->delete();

        return response()->json(['flash' => 'Funnel deleted successfully :)']);
    }
}
