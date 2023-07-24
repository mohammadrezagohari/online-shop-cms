<?php

namespace App;


use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

if (!function_exists("custom_pagination")) {
    /******************************************************
     * create a customized pagination for laravel
     *
     * @param mixed $models
     * your selected collection or model
     *
     * @param int $perPage
     * count of per page items
     *
     * @param int $page [optional]
     * you can set your page index with this
     * if it hasn't values, show first page
     * @param int $options [optional]
     * you can set others options in this item
     *
     * @return LengthAwarePaginator
     * it's send our pagination
     */
    function custom_pagination($models, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ? $page : (Paginator::resolveCurrentPage() ? Paginator::resolveCurrentPage() : 1);
        $models = $models instanceof Collection ? $models : Collection::make($models);
        return new LengthAwarePaginator($models->forPage($page, $perPage), $models->count(), $perPage, $page, $options);
    }
}
if (!function_exists("expire_date")) {
    /*********************************
     * set expire at after minutes
     * @param int $minutes [optional]
     ********************************/

    function expire_date(int $minutes = 2)
    {

        return Carbon::createFromFormat('Y-m-d H:i:s', now())->addMinutes($minutes)->toDateTime();
    }
}


if (!function_exists("random_otp_generator")) {
    /*********************************
     * get random code
     * @return int
     ********************************/
    function random_otp_generator(): int
    {
        return rand(1000, 9999);
    }
}

if (!function_exists("get_current_date_time")) {
    /*********************************
     * get random code
     ********************************/
    function get_current_date_time()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', now())->toDateTime();
    }
}

if (!function_exists("otp_generator")) {
    /*********************************
     * get random code
     ********************************/
    function otp_generator(\App\Models\User $user): Model
    {


        return $user->Otps()->create([
            'otp_code' => random_otp_generator(),
            'user_id' => $user->id,
            'expire_at' => expire_date(5)
        ]);
    }
}

if (!function_exists("upload_asset_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_asset_file($file, $path)
    {
        $random=rand(1000,9999);
        $fileName = time().$random . '.' . $file->extension();
        $prefix_asset = $path;
        $file->move(public_path($prefix_asset), $fileName);
        return $path."/". $fileName;
//        return $file->storeAs($prefix_asset, $fileName);
    }
}


if (!function_exists("final_amount_cart_items")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function final_amount_cart_items($number, $price,$color_price_increase,$guarantee_price_increase): string
    {
        return ($number*$price)+$color_price_increase+$guarantee_price_increase;

    }
}


if (!function_exists("order_final_amount")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function order_final_amount($id): int
    {
        return $id;

    }
}



if (!function_exists("final_product_price_without_amazing_sale")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function final_product_price_without_amazing_sale($price,$color_price_increase,$guarantee_price_increase): int
    {
        return $price+$color_price_increase+$guarantee_price_increase;

    }
}



if (!function_exists("final_total_price_without_amazing_sale")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function final_total_price_without_amazing_sale($number,$final_product_price): int
    {
        return $number*($final_product_price);

    }
}


if (!function_exists("final_product_price_with_amazing_sale")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function final_product_price_with_amazing_sale($price,$percentage,$color_price_increase,$guarantee_price_increase): int
    {
        return ($price*((100-$percentage)/100))+$color_price_increase+$guarantee_price_increase;

    }
}



if (!function_exists("final_total_price_with_amazing_sale")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function final_total_price_with_amazing_sale($number,$final_product_price_with_amazing_sale): int
    {
        return $number*$final_product_price_with_amazing_sale;

    }
}



if (!function_exists("upload_asset_background_file")) {
    /*********************************
     * upload asset file on storage
     ********************************/
    function upload_asset_background_file($file): string
    {
        $fileName = time() . '.' . $file->extension();
        $prefix_asset = 'assets/background';
        return $file->move(public_path($prefix_asset), $fileName);
//        return $file->storeAs($prefix_asset, $fileName);
    }
}


if (!function_exists("kavenegar_verification")) {
    /*********************************
     * send kavenegar sms
     ********************************/
    function kavenegar_verification($receptor, $token, $token2 = null, $token3 = null): mixed
    {
        $APIKEY = env('KAVENEGAR_API_KEY');
        $baseUrl = "https://api.kavenegar.com/v1/{$APIKEY}/verify/lookup.json";
        return Http::get($baseUrl, [
            'receptor' => $receptor,
            'token' => $token,
            'token2' => $token2,
            'token3' => $token3,
            'template' => env('KAVEHNEGAR_OTP_NAME'),
            'type' => 'sms'
        ]);
    }
}


if (!function_exists("get_reverse_geo_to_address")) {
    /*********************************
     * reverse geo location to address
     ********************************/
    function get_reverse_geo_to_address($latitude, $longitude)
    {
        $client = new Client();
        $url = "https://map.ir/reverse";
        $response = $client->request('GET', $url, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude
            ],
            'headers' => [
                'x-api-key' => env('MAP_IR_API_KEY')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        return response()->json($data);
    }
}




