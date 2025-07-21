<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        config([
            'mail.mailers.smtp.host' => setting('mail.host', env('MAIL_HOST')),
            'mail.mailers.smtp.port' => setting('mail.port', env('MAIL_PORT')),
            'mail.mailers.smtp.username' => setting('mail.username', env('MAIL_USERNAME')),
            'mail.mailers.smtp.password' => setting('mail.password', env('MAIL_PASSWORD')),
            'mail.from.address' => setting('mail.from_address', env('MAIL_FROM_ADDRESS')),
            'mail.from.name' => setting('mail.from_name', env('MAIL_FROM_NAME')),
        ]);
    }
}
