<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FunnelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all funnels, eager load related user and client
        $funnels = Funnel::with(['user', 'client', 'media'])->get();

        return response()->json($funnels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log raw incoming request data
        Log::info('Incoming funnel form data:', $request->all() ?? []);

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
            'flash' => 'Funnel sent successfully :)'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Funnel $funnel)
    {
        // Eager load related user and client
        $funnel->load(['user', 'client']);
        // Funnel Media If Any
        $funnel->load('media');

        return response()->json($funnel);
    }

   public function myClientFunnels()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        $funnels = Funnel::with(['user', 'client', 'media'])
            ->where('client_id', $user->client->id)
            ->get();

        return response()->json([
            'user' => $user,
            'client' => $user->client,
            'funnels' => $funnels
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Funnel $funnel)
{
    // Log raw incoming request data for debugging
    Log::info('Incoming funnel update data:', [
        'title' => $request->input('title'),
        'goal' => $request->input('goal'),
        'target_audience' => $request->input('target_audience'),
        'cta' => $request->input('cta'),
        'notes' => $request->input('notes'),
        'deadline' => $request->input('deadline'),
        'has_files' => $request->hasFile('media'),
        'deleted_media' => $request->input('deleted_media'),
    ]);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'goal' => 'required|string',
        'target_audience' => 'required|string',
        'cta' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'deadline' => 'required|date',
        'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp,pdf|max:10240',
        'deleted_media.*' => 'nullable|integer',
    ]);

    // Update the funnel
    $funnel->update($validated);

    // Handle deleted media
    if ($request->has('deleted_media')) {
        $mediaToDelete = $funnel->media()->whereIn('id', $request->input('deleted_media'))->get();
        
        foreach ($mediaToDelete as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }
    }

    // Handle new media uploads
    if ($request->hasFile('media')) {
        foreach ($request->file('media') as $file) {
            $filename = $file->store('funnel-media', 'public');
            $funnel->media()->create([
                'file_path' => $filename,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }
    }

    return response()->json([
        'flash' => 'Funnel updated successfully',
        'funnel' => $funnel->fresh()->load(['user', 'client', 'media'])
    ]);
}

    public function destroy(Funnel $funnel, Request $request)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $reason = $request->input('reason', 'No reason provided');
        
        Log::info("Funnel deleted - ID: {$funnel->id}, Title: {$funnel->title}, Reason: {$reason}");

        // Delete associated media files
        foreach ($funnel->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        $funnel->delete();

        return response()->json([
            'flash' => 'Funnel deleted successfully'
        ]);
    }
}
