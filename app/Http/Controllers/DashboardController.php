<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funnel;
use App\Models\Lead;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function clientDashboard(Request $request)
    {
        $user = auth()->user();

        // Fetch recent funnels with lead counts
        $funnels = Funnel::withCount('leads')
            ->where('user_id', $user->id)
            ->latest()
            ->take(3) 
            ->get()
            ->map(function ($funnel) {
                return [
                    'id'         => $funnel->id,
                    'name'       => $funnel->title,
                    'status'     => $funnel->status ?? 'pending',
                    'leads'      => $funnel->leads_count,
                    'conversion' => $funnel->conversion_rate
                        ? number_format($funnel->conversion_rate, 1) . '%'
                        : '0%',
                    'created'    => Carbon::parse($funnel->created_at)->diffForHumans(),
                    'url'        => $funnel->preview_link ?? null
                ];
            });

        // Fetch recent leads
        $leads = Lead::with('funnel')
            ->where('client_id', $user->client_id)
            ->latest()
            ->take(3) 
            ->get()
            ->map(function ($lead) {
                return [
                    'id'      => $lead->id,
                    'name'    => $lead->name,
                    'email'   => $lead->email,
                    'source'  => $lead->funnel->title ?? 'Unknown source',
                    'status'  => $lead->status ?? 'new',
                    'time'    => Carbon::parse($lead->created_at)->diffForHumans(),
                ];
            });

        return response()->json([
            'stats' => [
                [
                    'name'       => 'Total Funnels',
                    'value'      => (string) Funnel::where('user_id', $user->id)->count(),
                    'change'     => '+2.5%',
                    'changeType' => 'positive',
                    'icon'       => 'Zap',
                    'color'      => 'from-blue-500 to-cyan-500'
                ],
                [
                    'name'       => 'Active Leads',
                    'value'      => (string) Lead::where('client_id', $user->client_id)->count(),
                    'change'     => '+12.3%',
                    'changeType' => 'positive',
                    'icon'       => 'Users',
                    'color'      => 'from-green-500 to-emerald-500'
                ],
                [
                    'name'       => 'Conversion Rate',
                    'value'      => '24.8%',
                    'change'     => '+4.1%',
                    'changeType' => 'positive',
                    'icon'       => 'TrendingUp',
                    'color'      => 'from-purple-500 to-pink-500'
                ],
                [
                    'name'       => 'Email Opens',
                    'value'      => '89.2%',
                    'change'     => '-1.2%',
                    'changeType' => 'negative',
                    'icon'       => 'Mail',
                    'color'      => 'from-orange-500 to-red-500'
                ]
            ],
            'recentFunnels' => $funnels,
            'recentLeads'   => $leads
        ]);
    }
}
