<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Invitation;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::createUrlUsing(function ($notifiable) {
            $expiration = Carbon::now()->addMinutes(60);

            // Check if the user was invited (by email match)
            $wasInvited = Invitation::where('email', $notifiable->email)->exists();

            // Build base verification URL
            $params = [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ];

            // Only add redirectTo param if they were NOT invited
            if (!$wasInvited) {
                $params['redirectTo'] = 'onboarding';
            }

            return URL::temporarySignedRoute(
                'verification.verify',
                $expiration,
                $params
            );
        });
    }
}
