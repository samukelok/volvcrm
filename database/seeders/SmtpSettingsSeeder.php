<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SMTPSetting;

class SmtpSettingsSeeder extends Seeder
{
    public function run()
    {   

        SMTPSetting::updateOrCreate(
            ['fallback' => true, 'client_id' => null],
            [
                'name'       => 'System Fallback SMTP',
                'host'       => env('CLIENT_FALLBACK_HOST', 'smtp.example.com'),
                'port'       => env('CLIENT_FALLBACK_PORT', 587),
                'username'   => env('CLIENT_FALLBACK_USERNAME', 'system@example.com'),
                'password'   => env('CLIENT_FALLBACK_PASSWORD', 'secret'),
                'encryption' => env('CLIENT_FALLBACK_ENCRYPTION', 'tls'),
            ]
        );
    }
}
