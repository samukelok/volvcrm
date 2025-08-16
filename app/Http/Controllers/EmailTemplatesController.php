<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplatesController extends Controller
{
    /**
     * Display a listing of the client's templates.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        $templates = EmailTemplate::where('client_id', $user->client_id)
            ->with('user')
            ->get();

        return response()->json($templates->map(function ($template) {
            return [
                'id' => $template->id,
                'name' => $template->name,
                'subject' => $template->subject,
                'body_html' => $template->body_html,
                'body_text' => $template->body_text,
                'category' => $template->category,
                'is_default' => $template->is_default,
                'created_at' => $template->created_at,
                'updated_at' => $template->updated_at,
                'user_id' => $template->user_id,
                'created_by' => $template->user ? $template->user->name : null,
            ];
        }));
    }

    /**
     * Show the specified template (client-scoped).
     */
    public function show(EmailTemplate $emailTemplate)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        if (!$user->client) {
            return response()->json(['error' => 'User has no associated client'], 400);
        }

        if ($emailTemplate->client_id !== $user->client_id) {
            return response()->json(['error' => 'You are not authorized to view this template'], 403);
        }

        $emailTemplate->load('user');

        return response()->json([
            'id' => $emailTemplate->id,
            'name' => $emailTemplate->name,
            'subject' => $emailTemplate->subject,
            'body_html' => $emailTemplate->body_html,
            'body_text' => $emailTemplate->body_text,
            'category' => $emailTemplate->category,
            'is_default' => $emailTemplate->is_default,
            'created_at' => $emailTemplate->created_at,
            'updated_at' => $emailTemplate->updated_at,
            'user_id' => $emailTemplate->user_id,
            'created_by' => $emailTemplate->user ? $emailTemplate->user->name : null,
        ]);
    }

    /**
     * Store a newly created template for the client.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->client) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'body_text' => 'required|string',
            'category' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        $data['client_id'] = $user->client_id;
        $data['user_id'] = $user->id;

        $template = EmailTemplate::create($data);

        return response()->json($template, 201);
    }

    /**
     * Update a template (client-scoped).
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $user = Auth::user();
        if (!$user || !$user->client || $emailTemplate->client_id !== $user->client_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string|max:255',
            'body_html' => 'sometimes|string',
            'body_text' => 'sometimes|string',
            'category' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        $emailTemplate->update($data);

        return response()->json($emailTemplate);
    }

    /**
     * Delete a template (client-scoped).
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $user = Auth::user();
        if (!$user || !$user->client || $emailTemplate->client_id !== $user->client_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $emailTemplate->delete();

        return response()->json(['message' => 'Template deleted successfully']);
    }
}
