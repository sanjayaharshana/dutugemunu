<?php

namespace App\Providers;

use App\Support\SiteContent;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        // Serve all `config('association.*')` reads from the database
        // (cached), with config/association.php as the fallback.
        config(['association' => SiteContent::all()]);

        // Keep the public site fresh after console changes (seed / migrate).
        Event::listen(CommandFinished::class, function (CommandFinished $event) {
            if (in_array($event->command, ['db:seed', 'migrate', 'migrate:fresh', 'optimize:clear'], true)) {
                SiteContent::forget();
            }
        });
    }
}
