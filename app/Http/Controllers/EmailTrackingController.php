<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmailTrackingController extends Controller
{
    /**
     * Track email open.
     */
    public function open($leadId, $emailLogId)
    {
        $log = EmailLog::find($emailLogId);
        if ($log && !$log->opened_at) {
            $log->update(['opened_at' => now()]);
        }

        // Return 1x1 transparent pixel
        return response(base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=='))
            ->header('Content-Type', 'image/gif');
    }

    /**
     * Track email click.
     */
    public function click(Request $request, $leadId, $emailLogId)
    {
        $redirectUrl = $request->query('redirect');
        $log = EmailLog::find($emailLogId);
        if ($log && !$log->clicked_at) {
            $log->update(['clicked_at' => now()]);
        }

        return Redirect::to($redirectUrl ?? '/');
    }
}
