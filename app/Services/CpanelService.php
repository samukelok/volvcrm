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

    public function createSubdomain($subdomain, $domain = 'cyberkru.com')
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

    public function createWildcardDNSRecord($domain = 'cyberkru.com', $ip = '170.10.163.46')
    {
        $endpoint = "{$this->cpanelHost}/execute/ZoneEdit/add_zone_record";

        $response = Http::withBasicAuth($this->cpanelUser, $this->cpanelPass)
            ->get($endpoint, [
                'domain' => $domain,
                'name' => '*.' . $domain . '.', 
                'type' => 'A',
                'address' => $ip,
                'ttl' => '14400',
            ]);

        return $response->json();
    }
}