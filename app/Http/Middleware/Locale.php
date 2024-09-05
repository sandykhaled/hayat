<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        date_default_timezone_set('Asia/Dubai');
        $locale = $request->session()->get('Lang');
        $availableLocales = config('app.locales', []); // Default to an empty array if null

        if ($locale !== null && in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        }
        if ($locale === null) {
            $request->session()->put('Lang', config('app.locale'));
        }
        return $next($request);
    }
}
