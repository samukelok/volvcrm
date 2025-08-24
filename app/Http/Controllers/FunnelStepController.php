<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use App\Models\FunnelStep;
use App\Models\EmailTemplate;
use App\Jobs\SendFunnelStepEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FunnelStepController extends Controller
{
    /**
     * List steps for a funnel
     */
    public function index(Funnel $funnel)
    {
        $user = Auth::user();
        if (!$user || !$user->client) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($funnel->client_id !== $user->client->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $steps = $funnel->steps()->with('emailTemplates')->get();
        return response()->json($steps);
    }

    /**
     * Create a new funnel step
     */
    public function store(Request $request, Funnel $funnel)
    {
        $user = Auth::user();
        if (!$user || !$user->client || $funnel->client_id !== $user->client->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'delay_days' => 'required|integer|min:0',
            'condition' => 'nullable|string',
            'template_ids' => 'nullable|array',
            'template_ids.*' => 'exists:email_templates,id'
        ]);

        $step = $funnel->steps()->create([
            'name' => $validated['name'],
            'delay_days' => $validated['delay_days'],
            'condition' => $validated['condition'] ?? null,
        ]);

        if (!empty($validated['template_ids'])) {
            // Attach templates with order
            $syncData = [];
            foreach ($validated['template_ids'] as $index => $id) {
                $syncData[$id] = ['order_in_step' => $index + 1];
            }
            $step->emailTemplates()->sync($syncData);
        }

        return response()->json(['message' => 'Funnel step created', 'step' => $step]);
    }

    /**
     * Dispatch emails for a step
     */
    public function sendEmails(FunnelStep $step)
    {
        $user = Auth::user();
        if (!$user || !$user->client || $step->funnel->client_id !== $user->client->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        SendFunnelStepEmails::dispatch($step);

        return response()->json(['message' => 'Emails queued for sending']);
    }

    /**
     * Show a single step
     */
    public function show(FunnelStep $step)
    {
        $user = Auth::user();
        if (!$user || !$user->client || $step->funnel->client_id !== $user->client->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $step->load('emailTemplates');
        return response()->json($step);
    }

    /**
     * Delete a funnel step
     */
    public function destroy(FunnelStep $step)
    {
        $user = Auth::user();
        if (!$user || !$user->client || $step->funnel->client_id !== $user->client->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $step->delete();
        return response()->json(['message' => 'Funnel step deleted']);
    }
}
