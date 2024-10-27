<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class IPSessionMiddlewire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $ip = request()->ip() == '127.0.0.1' ? '221.120.227.235' : request()->ip();
        $ip = request()->ip() == '127.0.0.1' ? '27.147.191.221' : request()->ip();
        if (!Session::has('user_country') || !Session::has('user_city') || (Session::get('ip') != $ip)) {
            // Get the user's IP address
            // Fetch location data
            $location = Location::get($ip);

            if ($location) {
                $country = $location->countryName;
                $city = $location->cityName;
                $currency_code = $location->currencyCode;

                $currency = Currency::where('status', 1)->where('code', $currency_code)->select('id','symbol')->first();
                if (isset($currency)) {
                    Session::put('currency_id', $currency->id);
                    Session::put('currency_symbol', $currency->symbol);
                    Session::put('currency_code', $currency_code ?? "USD");
                }

                Session::put('country_flag', 'https://flagsapi.com/' . $location->countryCode . '/flat/64.png');
                Session::put('user_country', $country);
                Session::put('user_city', $city);
                Session::put('ip', $ip);
            }
        }
        return $next($request);
    }
}
