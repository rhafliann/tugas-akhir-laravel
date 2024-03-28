<?php

namespace App\Providers;

use App\Jobs\ProcessLogFingerprint;
use App\Models\EmailConfiguration;
use App\Models\User;
use App\Observers\UserProfileObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // using sanctum for api authentication
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        try {
            if (\Schema::hasTable('email_configuration')) {
                $mailsetting = EmailConfiguration::first();
                if ($mailsetting) {
                    config(['mail.default' => $mailsetting->protocol]);
                    config(['mail.mailers.smtp.host' => $mailsetting->host]);
                    config(['mail.mailers.smtp.port' => $mailsetting->port]);
                    config(['mail.mailers.smtp.encryption' => $mailsetting->tls]);
                    config(['mail.mailers.smtp.username' => $mailsetting->username]);
                    config(['mail.mailers.smtp.password' => $mailsetting->password]);
                    config(['mail.mailers.form.address' => $mailsetting->email]);
                    config(['mail.mailers.form.name' => 'si-mase']);
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }

        User::observe(UserProfileObserver::class);

        Gate::define('isAdmin', function (User $user) {
            return $user->level === 'admin';
        });

        Gate::define('isBod', function (User $user) {
            return $user->level === 'bod';
        });

        Gate::define('isPpk', function (User $user) {
            return $user->level === 'ppk';
        });

        Gate::define('isKadiv', function (User $user) {
            return $user->level === 'kadiv';
        });
		
		Gate::define('isStaf', function (User $user) {
            return $user->level === 'staf';
        });

    }
}