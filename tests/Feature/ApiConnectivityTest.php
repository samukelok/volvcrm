<?php

namespace Tests\Feature;

use App\Services\CpanelService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiConnectivityTest extends TestCase
{
    public function test_it_can_connect_to_cpanel_and_create_a_subdomain()
    {
        // Optionally, you can use Http::fake() here to avoid real API calls during automated testing.
        //Http::fake();

        $service = new CpanelService();

        // Use a random subdomain to avoid conflicts
        $subdomain = 'test' . rand(1000, 9999);

        $response = $service->createSubdomain($subdomain);

        // Dump the response for debugging
        dump($response);

        // Assert the response has the expected structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
    }
}