<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CpanelService
{
    protected $cpanelUser;
    protected $cpanelPass;
    protected $cpanelHost;

    public function __construct()
    {
        $this->cpanelUser = env('CPANEL_USER');
        $this->cpanelPass = env('CPANEL_PASS');
        $this->cpanelHost = env('CPANEL_HOST');
    }

    public function createSubdomain($subdomain, $domain = 'bluenroll.co.za')
    {
        $endpoint = "{$this->cpanelHost}/execute/SubDomain/addsubdomain";

        $response = Http::withBasicAuth($this->cpanelUser, $this->cpanelPass)
            ->get($endpoint, [
                'domain' => $subdomain,
                'rootdomain' => $domain,
                'dir' => "public_html/{$subdomain}",
            ]);

        return $response->json();
    }
}