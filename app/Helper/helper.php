<?php

use App\Models\Logger;

function getCurrentRoute($p)
{
    $data = explode(".", $p);
    return $data[1];
}
function saveMyLiveProduct($array)
{
    $temp = [];
    foreach ($array as $key => $value) {
        if (!is_null($value->product)) {

            array_push($temp, $value);
        }
        return $temp;
    }
}

function saveImageBase64Company($base64)
{
    $image = $base64;
    $extention =  explode('/', mime_content_type($image))[1];
    $image = str_replace('data:image/' . $extention . ';base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $path = 'uploads/' . date('mdYHis') . Illuminate\Support\Str::random(32) . uniqid() . '.' . $extention;
    Illuminate\Support\Facades\Storage::disk('public')->put($path, base64_decode($image), 'public');
    return $path;
}
function saveImageBase64($base64)
{
    $image = $base64;
    $extention =  explode('/', mime_content_type($image))[1];
    $image = str_replace('data:image/' . $extention . ';base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $path = 'qrcode/' . date('mdYHis') . Illuminate\Support\Str::random(32) . uniqid() . '.' . $extention;
    Illuminate\Support\Facades\Storage::disk('public')->put($path, base64_decode($image), 'public');
    return $path;
}
function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from remote address
    else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}
