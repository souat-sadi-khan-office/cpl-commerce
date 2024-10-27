<?php

use App\CPU\Helpers;
use App\Models\Category;
use App\Models\Currency;
use App\Models\HomepageSettings;
use App\Models\ConfigurationSetting;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

if (!function_exists('get_setting')) {
    function get_settings($key, $default = null)
    {
        // if (Session::has('settings.' . $key)) {
        //     return Session::get('settings.' . $key, $default);
        // }

        $value = false;
        $setting = ConfigurationSetting::where('type', $key)->first();
        if ($setting) {
            $value = $setting->value;
        }
        // if ($setting !== null) {
        //     Session::put('settings.' . $key, $setting->value);
        //     return $setting->value;
        // }

        return $value;
    }
}

// HomepageSettings
if (!function_exists('homepage_setting')) {
    function homepage_setting($key)
    {
        if (Session::has('homepage_setting.' . $key)) {

            return Session::get('homepage_setting.' . $key);
        }

        $settings = HomepageSettings::first();

        if ($settings) {
            $data = [
                "bannerSection" => $settings->bannerSection,
                "sliderSection" => $settings->sliderSection,
                "midBanner" => $settings->midBanner,
                "dealOfTheDay" => $settings->dealOfTheDay,
                "trending" => $settings->trending,
                "brands" => $settings->brands,
                "popularANDfeatured" => $settings->popularANDfeatured,
                "newslatter" => $settings->newslatter,
                "last_updated_by" => Helpers::adminName($settings->last_updated_by),
                "last_updated_at" => $settings->updated_at,
            ];

            foreach ($data as $k => $setting) {
                Session::put('homepage_setting.' . $k, $setting);
            }

            return Session::get('homepage_setting.' . $key);
        } else {
            $new = new HomepageSettings();
            $new->last_updated_by = Auth::guard('admin')->id();
            $new->save();

            return false;
        }

        return false;
    }
}

// format date
if (!function_exists('get_system_date')) {
    function get_system_date($date)
    {

        $dateObj = Carbon\Carbon::parse($date);
        $dateObj->setTimezone(get_settings('system_timezone') ? get_settings('system_timezone') : 'Asia/Dhaka');

        $dateFormat = get_settings('system_date_format') ?? 'Y-m-d';

        if ($dateFormat) {
            return $dateObj->format($dateFormat);
        } else {
            return $dateObj->format('Y-m-d');
        }
    }
}
if (!function_exists('add_line_breaks')) {
    function add_line_breaks($text, $wordsPerLine = 30) {
        $words = explode(' ', $text);
        $chunks = array_chunk($words, $wordsPerLine);

        $lines = array_map(function($chunk) {
            return implode(' ', $chunk);
        }, $chunks);

        return implode('<br>', $lines);
    }
}

// format time
if (!function_exists('get_system_time')) {
    function get_system_time($time, $timezone = null)
    {
        $dateObj = Carbon\Carbon::parse($time);

        if ($timezone) {
            $dateObj->setTimezone($timezone);
        } else {
            $dateObj->setTimezone(get_settings('system_timezone') ? get_settings('system_timezone') : 'Asia/Dhaka');
        }

        $timeFormat = get_settings('system_time_format') ?? 'H:i:s A';

        return $dateObj->format($timeFormat);
    }
}

if (!function_exists('tz_list')) {
    function tz_list()
    {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price, $isMinimize = false, $isAdmin = false)
    {
        if (get_settings('system_decimal_separator') == 1) {
            $format_price = number_format($price, intval(get_settings('system_no_of_decimals')));
        } else {
            $format_price = number_format($price, intval(get_settings('system_no_of_decimals')), ',', '.');
        }

        // Minimize the price 
        if ($isMinimize) {
            $temp = number_format($price / 1000000000, get_settings('system_no_of_decimals'), ".", "");

            if ($temp >= 1) {
                $format_price = $temp . "B";
            } else {
                $temp = number_format($price / 1000000, get_settings('system_no_of_decimals'), ".", "");
                if ($temp >= 1) {
                    $format_price = $temp . "M";
                }
            }
        }

        if (get_settings('system_symbol_format') == '[Symbol][Amount]') {
            return currency_symbol($isAdmin) . $format_price;
        } else if (get_settings('system_symbol_format') == "[Symbol] [Amount]") {
            return currency_symbol($isAdmin) . ' ' . $format_price;
        } else if (get_settings('system_symbol_format') == "[Amount] [Symbol]") {
            return $format_price . ' ' . currency_symbol($isAdmin);
        }

        return $format_price . currency_symbol($isAdmin);
    }
}

function covert_to_usd($price)
{
    if ((get_system_default_currency()->code != "USD")) {
        return ($price / get_exchange_rate(get_system_default_currency()->code));
    }
    return $price;
}
function covert_to_defalut_currency($price)
{
    if ((get_system_default_currency()->code != "USD")) {
        return ($price * get_exchange_rate(get_system_default_currency()->code));
    }
    return $price;
}

// converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        if (Session::has('currency_code') && (Session::get('currency_code') != "USD")) {
            $currency_code = Session::get('currency_code');
            $exchange_rate = get_exchange_rate($currency_code);

            if ($exchange_rate !== null) {
                $price = floatval($price) * $exchange_rate;
            }
        }
        return $price;
    }
}



function fetch_exchange_rate($currency_code)
{
    $api_url = "https://api.currencybeacon.com/v1/convert?api_key=tisDcm3hOvaLnnbrZPP1I5UMgF2JSzkL&from=USD&to=" . strtoupper($currency_code) . "&amount=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
function store_exchange_rate($currency_code, $rate)
{
    // Try to find the existing currency entry
    $currency = Currency::where('code', $currency_code)->first();

    if ($currency) {
        // If it exists, update the exchange rate
        $currency->exchange_rate = $rate;
        $currency->save();
    }

    // Store in cache as well
    Cache::put("exchange_rate_{$currency_code}", $rate, get_settings('currency_api_fetch_time') ?? 3600);
}

function getProductStock($productId, $qty = 1)
{
    // getting the product
    $product = Product::find($productId);
    if(!$product) {
        return ['status' => false, 'message' => 'Product Not Found'];
        // return response()->json(['status' => false, 'message' => 'Product Not Found']);
    }

    // checking product status
    if($product->status == 0) {
        return ['status' => false, 'message' => 'Product is currently not in sale'];
    }

    // checking product in_stock status
    if($product->in_stock == 0) {
        return ['status' => false, 'message' => 'Product is currently out of stock'];
    }

    // getting product stock type
    $stockType = $product->stock_types;

    // checking current stock
    if(!$product->details) {
        return ['status' => false, 'message' => 'Product Information Not Found'];
    }

    if($product->details->current_stock < $qty) {
        return ['status' => false, 'message' => 'This product is not available in the desired quantity or not in stock'];
    }

    // checking product stock
    if(!$product->stock) {
        return ['status' => false, 'message' => 'Product Stock Not Found'];
    }

    switch($stockType) {
        case 'globally':

            $stock = $product->stock->where('in_stock', 1)->first();
            if(!$stock) {
                return ['status' => false, 'message' => 'Product is out of stock'];
            }
            
            return ['status' => true, 'stock' => $stock->stock];
        break;
        case 'country_wise':
            if(!Session::has('user_country')) {
                return ['status' => false, 'message' => 'Please select your country to buy this product'];
            }

            if(Session::get('user_country') != '') {
                $userCountry = Session::get('user_country');
                
                $country = Country::where('name', $userCountry)->first();
                if(!$country) {
                    return ['status' => false, 'message' => 'This product has no stock in your country. Please change your country.'];
                }

                $countryId = $country->id;
                $stock = $product->stock->where('in_stock', 1)->where('country_id', $countryId)->first();
                if(!$stock) {
                    return ['status' => false, 'message' => 'This product has no stock in your country. Please change your country.'];
                }

                return ['status' => true, 'stock' => $stock->stock];
            }
        break;
        case 'city_wise':
            if(!Session::has('user_country')) {
                return ['status' => false, 'message' => 'Please select your country to buy this product'];
            }

            // if(Session::get('user_country') != '') {
            //     $userCountry = Session::get('user_country');
                
            //     $country = Country::where('name', $userCountry)->first();
            //     if(!$country) {
            //         return ['status' => false, 'message' => 'This product has no stock in your country. Please change your country.'];
            //     }

            //     $countryId = $country->id;
            //     $stock = $product->stock->where('in_stock', 1)->where('country_id', $countryId)->first();
            //     if(!$stock) {
            //         return ['status' => false, 'message' => 'This product has no stock in your country. Please change your country.'];
            //     }

            //     return ['status' => true, 'stock' => $stock->stock];
            // }

            return ['status' => true, 'stock' => 0];
        break;
    }
}

function get_exchange_rate($currency_code)
{
    $fetch_time = 3600;
    if(get_settings('currency_api_fetch_time') > 0) {
        $fetch_time = get_settings('currency_api_fetch_time');
    }
    return Cache::remember("exchange_rate_{$currency_code}", $fetch_time, function () use ($currency_code) {
        // Check if the currency exists in the database
        $currency = Currency::where('code', $currency_code)->first();

        // If the currency exists, fetch the exchange rate from the API
        if ($currency) {
            $exchange_rate_data = fetch_exchange_rate($currency_code);
            if ($exchange_rate_data && $exchange_rate_data['meta']['code'] == 200) {
                $rate = $exchange_rate_data['response']['value'];
                // Store in the database
                store_exchange_rate($currency_code, $rate);
                return $rate; // Return the newly fetched rate
            }
        }

        // If currency is not found or API call fails, return null
        return null;
    });
}


// Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

function encode($value){
    return base64_encode(urlencode(base64_encode($value))); // Encode
}
function decode($encoded){
    return base64_decode(urldecode(base64_decode($encoded)));
}

// Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        $discount_applicable = false;

        if ($product->is_discounted == 1) {
            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            } elseif (
                strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
            ) {
                $discount_applicable = true;
            }
        } else {
            $discount_applicable = false;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percentage') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//gets currency symbol
if (!function_exists('currency_symbol')) {
    function currency_symbol($isAdmin = false)
    {
        if ($isAdmin) {
            return isset(get_system_default_currency()->symbol) ? get_system_default_currency()->symbol : '$';
        }
        if (Session::has('currency_symbol')) {
            return Session::get('currency_symbol');
        }

        return isset(get_system_default_currency()->symbol) ? get_system_default_currency()->symbol : '$';
    }
}

if (!function_exists('get_system_default_currency')) {
    function get_system_default_currency()
    {
        $currency = Currency::find(get_settings('system_default_currency'));
        if (!$currency) {
            $currency = Currency::where('name', 'US Dollar')->first();
        }
        return $currency;
    }
}

if (!function_exists('get_immediate_children_ids')) {
    function get_immediate_children_ids($id, $with_trashed = false)
    {
        $children = get_immediate_children($id, $with_trashed, true);

        return !empty($children) ? array_column($children, 'id') : array();
    }
}

if (!function_exists('get_immediate_children_count')) {
    function get_immediate_children_count($id, $with_trashed = false)
    {
        return $with_trashed ? Category::where('status', 1)->where('parent_id', $id)->count() : Category::where('status', 1)->where('parent_id', $id)->count();
    }
}

if (!function_exists('get_immediate_children')) {
    function get_immediate_children($id, $with_trashed = false, $as_array = false)
    {
        $children = $with_trashed ? Category::where('status', 1)->where('parent_id', $id)->orderBy('name', 'ASC')->get() : Category::where('status', 1)->where('parent_id', $id)->orderBy('name', 'ASC')->get();
        $children = $as_array && !is_null($children) ? $children->toArray() : $children;

        return $children;
    }
}
