<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        Blade::if('canmatch', function ($pattern) {
            $user = auth()->user();
            if (!$user || !method_exists($user, 'permissions')) return false;

            return $user->permissions
                ->pluck('name')
                ->contains(fn($name) => Str::is($pattern, $name));
        });
    }
}
