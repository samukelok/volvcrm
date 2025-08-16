<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewFunnelNotification;
use App\Mail\UpdatedFunnelNotification;
use Illuminate\Support\Facades\Mail;

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

        $user = Auth::user();

        // Send email notifications
        $clientUsers = $funnel->client?->users ?? collect();

        $admins = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

        $recipients = $clientUsers->merge($admins);

        foreach ($recipients as $user) {
            Mail::to($user->email)->queue(new NewFunnelNotification($funnel));
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
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        if ($funnel->client_id !== $user->client_id) {
            return response()->json(['error' => 'You are not authorized to view this funnel'], 403);
        }

        $funnel->load(['user', 'client', 'media']);

        // Return the funnel data 
        return response()->json([
            'id' => $funnel->id,
            'title' => $funnel->title,
            'goal' => $funnel->goal,
            'target_audience' => $funnel->target_audience,
            'cta' => $funnel->cta,
            'notes' => $funnel->notes,
            'deadline' => $funnel->deadline,
            'priority' => $funnel->priority,
            'status' => $funnel->status,
            'created_at' => $funnel->created_at,
            'user_id' => $funnel->user_id,
            'requested_by' => $funnel->user ? $funnel->user->name : null,
            'preview_link' => $funnel->preview_link,
            'media' => $funnel->media,
        ]);
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

        // Notify users
        $clientUsers = $funnel->client?->users ?? collect();
        
        // Log Client Users
        Log::info('Client Users: ' . json_encode($clientUsers));

        $admins = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

        // Log Admins
        Log::info('Admins: ' . json_encode($admins));

        $recipients = $clientUsers->merge($admins);

        // Log Recipients
        Log::info('Recipients: ' . json_encode($recipients));

        foreach ($recipients as $user) {
            Mail::to($user->email)->queue(new UpdatedFunnelNotification($funnel));
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

        // Save the reason on the funnel before soft deleting
        $funnel->deleted_reason = $reason;
        $funnel->save();

        $funnel->delete();

        Log::info("Funnel soft-deleted - ID: {$funnel->id}, Title: {$funnel->title}, Reason: {$reason}");

        return response()->json([
            'flash' => 'Funnel deleted successfully'
        ]);
    }
}
