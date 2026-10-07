<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        Paginator::defaultView('pagination::default');
        Paginator::defaultSimpleView('pagination::simple-default');

        // @money($amount) prints an amount with the currency symbol from the settings table.
        Blade::directive('money', fn (string $expression) => "<?php echo e(\\App\\Models\\Setting::money({$expression})); ?>");

        // $site holds the site-wide settings (name, contact details, ...) in every view.
        View::composer('*', fn ($view) => $view->with('site', Setting::values()));
        //
    }
}
