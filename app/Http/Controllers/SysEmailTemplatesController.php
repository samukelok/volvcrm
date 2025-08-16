<?php

namespace App\Http\Controllers;

use App\Models\SysEmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SysEmailTemplatesController extends Controller
{
    /**
     * List all system templates
     */
    public function index()
    {
        $templates = SysEmailTemplate::all();
        return response()->json($templates);
    }

    /**
     * Show a specific system template
     */
    public function show(SysEmailTemplate $sysEmailTemplate)
    {
        return response()->json($sysEmailTemplate);
    }

    /**
     * Store a new system template
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'body_text' => 'nullable|string',
            'category' => 'required|in:welcome,follow_up,promo,reminder,newsletter',
            'is_default' => 'boolean',
        ]);

        $template = SysEmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body_html' => $request->body_html,
            'body_text' => $request->body_text,
            'category' => $request->category,
            'is_default' => $request->is_default ?? true,
        ]);

        return response()->json($template, 201);
    }

    /**
     * Update a system template
     */
    public function update(Request $request, SysEmailTemplate $sysEmailTemplate)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string|max:255',
            'body_html' => 'sometimes|string',
            'body_text' => 'nullable|string',
            'category' => 'sometimes|in:welcome,follow_up,promo,reminder,newsletter',
            'is_default' => 'boolean',
        ]);

        $sysEmailTemplate->update($request->all());

        return response()->json($sysEmailTemplate);
    }

    /**
     * Delete a system template
     */
    public function destroy(SysEmailTemplate $sysEmailTemplate)
    {
        $sysEmailTemplate->delete();
        return response()->json(['message' => 'System template deleted successfully']);
    }
}
