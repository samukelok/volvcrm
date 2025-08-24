<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Funnel;
use App\Models\LeadStatusChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Csv\Writer;
use SplTempFileObject;

class LeadsController extends Controller
{
    public function index()
    {
        return Lead::with('statusChanges')->latest()->get();
    }

    // Public endpoint for landing page submissions
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:25',
            'funnel_id' => 'required|exists:funnels,id', 
            'metadata' => 'nullable|array' 
        ]);

        // Get the funnel (landing page) details
        $funnel = Funnel::find($validated['funnel_id']);

        // Create lead with automatic user/client assignment
        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'funnel_id' => $validated['funnel_id'],
            'source' => $funnel->title, 
            'source_type' => 'ads', 
            'client_id' => $funnel->client_id, 
            'user_id' => $funnel->user_id, 
            'metadata' => $validated['metadata'] ?? null,
            'status' => 'new'
        ]);

        return response()->json([
            'success' => true,
            'preview_link' => $funnel->preview_link
        ], 201);
    }

    // Auth-only endpoint for company leads
    public function companyLeads()
    {
        $user = Auth::user();

        if (!$user->client_id) {
            return response()->json(['error' => 'Unauthorized - Not associated with any client'], 403);
        }

        return Lead::where('client_id', $user->client_id)
            ->with([
                'funnel' => function ($query) {
                    $query->select('id', 'title', 'preview_link');
                }
            ])
            ->latest()
            ->get()
            ->map(function ($lead) {
                return [
                    'id'=> $lead->id,
                    'name' => $lead->name,
                    'niche_category' => $lead->niche_category,
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'pays' => $lead->pays,
                    'source' => $lead->funnel ? $lead->funnel->title : 'Direct',
                    'status' => $lead->status,
                    'created_at' => $lead->created_at->toDateTimeString()
                ];
            });
    }

    public function show(Lead $lead)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        if ($lead->client_id !== $user->client_id) {
            return response()->json(['error' => 'You are not authorized to view this funnel'], 403);
        }

        return $lead->load('statusChanges');
    }

    public function update(Request $request, Lead $lead)
    {
        $oldStatus = $lead->status;

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'niche_category' => 'nullable|string|max:255',
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
            $userId = auth()->id() ?? $validated['user_id'] ?? null;

            LeadStatusChange::create([
                'lead_id' => $lead->id,
                'from_status' => $oldStatus,
                'to_status' => $validated['status'],
                'user_id' => $userId,
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

    public function export()
    {
        try {
            // Use chunking for memory efficiency
            $csv = Writer::createFromFileObject(new SplTempFileObject());

            // Headers
            $csv->insertOne([
                'Name',
                'Email',
                'Phone',
                'Niche',
                'Pays',
                'Source',
                'Status',
                'Created At',
                'Funnel',
                'Client'
            ]);

            Lead::with(['funnel', 'client', 'user'])
                ->chunk(500, function ($leads) use ($csv) {
                    foreach ($leads as $lead) {
                        $csv->insertOne([
                            $lead->name,
                            $lead->email,
                            $lead->phone ?? 'N/A',
                            $lead->niche_category,
                            $lead->pays ?? 'N/A',
                            $lead->source,
                            $lead->status,
                            $lead->created_at->format('Y-m-d H:i:s'),
                            $lead->funnel->title ?? 'N/A',
                            $lead->client->brand_name ?? 'N/A'
                        ]);
                    }
                });

            return response()->streamDownload(
                function () use ($csv) {
                    echo $csv->getContent();
                },
                'leads_export_' . now()->format('Y-m-d') . '.csv',
                ['Content-Type' => 'text/csv']
            );

        } catch (\Exception $e) {
            \Log::error('Export failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Export failed. Please try again later.'
            ], 500);
        }
    }

    private function generateCsvContent($leads)
    {
        $output = fopen('php://temp', 'w');

        // Write headers
        fputcsv($output, [
            'Name',
            'Email',
            'Phone',
            'Niche',
            'Monthly Pays',
            'Source',
            'Status',
            'Created At',
            'Funnel',
            'Client',
            'Assigned To'
        ]);

        // Write rows
        foreach ($leads as $lead) {
            fputcsv($output, [
                $lead->name,
                $lead->email,
                $lead->phone,
                $lead->niche_category,
                $lead->pays,
                $lead->source,
                $lead->status,
                $lead->created_at->format('Y-m-d H:i:s'),
                $lead->funnel->title ?? 'N/A',
                $lead->client->name ?? 'N/A',
                $lead->user->name ?? 'N/A'
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}
