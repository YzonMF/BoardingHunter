<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Makes the admin-edited site name the application name, so emails
 * (password reset, ...) are sent "from" the same name the site shows.
 */
class ApplySiteSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        $name = Setting::get('site_name');

        config(['app.name' => $name, 'mail.from.name' => $name]);

        return $next($request);
    }
}
