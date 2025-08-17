<?php

namespace App\Http\Controllers;

use App\Models\SysEmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SysEmailTemplatesController extends Controller
{
    /**
     * List all system templates
     */
    public function index()
    {
        $templates = SysEmailTemplate::all();

        // Append public URL for preview_img
        $templates->map(function ($template) {
            if ($template->preview_img) {
                $template->preview_img_url = $template->preview_img;
            }
            return $template;
        });

        return response()->json($templates);
    }

    /**
     * Show a specific system template
     */
    public function show(SysEmailTemplate $sysEmailTemplate)
    {
        if ($sysEmailTemplate->preview_img) {
            $sysEmailTemplate->preview_img_url = $sysEmailTemplate->preview_img;
        }
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
            'preview_img' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp,pdf|max:10240',
            'description' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        $filePath = null;

        if ($request->hasFile('preview_img')) {
            // Save into /storage/app/public/sys_templates/
            $filePath = $request->file('preview_img')->store('sys_templates', 'public');
        }

        $template = SysEmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body_html' => $request->body_html,
            'body_text' => $request->body_text,
            'category' => $request->category,
            'preview_img' => $filePath ? asset('storage/' . $filePath) : null,
            'description' => $request->description,
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
            'preview_img' => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp,pdf|max:10240',
            'description' => 'sometimes|string',
            'is_default' => 'boolean',
        ]);

        if ($request->hasFile('preview_img')) {
            // delete old file if exists
            if ($sysEmailTemplate->preview_img && Storage::disk('public')->exists($sysEmailTemplate->preview_img)) {
                Storage::disk('public')->delete($sysEmailTemplate->preview_img);
            }

            $filePath = $request->file('preview_img')->store('sys_email_templates', 'public');
            $sysEmailTemplate->preview_img = $filePath;
        }

        $sysEmailTemplate->fill($request->except('preview_img'));
        $sysEmailTemplate->save();

        $sysEmailTemplate->preview_img_url = $sysEmailTemplate->preview_img ? Storage::url($sysEmailTemplate->preview_img) : null;

        return response()->json($sysEmailTemplate);
    }

    /**
     * Delete a system template
     */
    public function destroy(SysEmailTemplate $sysEmailTemplate)
    {
        if ($sysEmailTemplate->preview_img && Storage::disk('public')->exists($sysEmailTemplate->preview_img)) {
            Storage::disk('public')->delete($sysEmailTemplate->preview_img);
        }

        $sysEmailTemplate->delete();
        return response()->json(['message' => 'System template deleted successfully']);
    }
}
