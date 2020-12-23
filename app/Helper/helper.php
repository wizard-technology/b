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

function sendFirebaseMessage($token, $title, $body,$screen)
{
    $url = "https://fcm.googleapis.com/fcm/send"; 
    $serverKey = 'AAAAP4vZgY8:APA91bGzYrXbq8bRt535zFjtnwkyiYqV_1UG0lYwZ5GowdrgJbVe7QZP1GWuNkE0AaVAU7YQpQ0aHGjAZy3o194hoS7xhHokhpwT03OW7iEpeNbdGVJP0IkuZnzkd3miMKCQElWjNiCE';

    $notification = array(
        'title' => $title,
        'body' => $body,
        'sound' => 'default',
        // 'icon' => asset('icon.png'),
        'badge' => '1',
    );
    $arrayToSend = array(
        'to' => $token,
        'notification' => $notification,
        'data' => $screen,
        'priority' => 'high',
    );
    $json = json_encode($arrayToSend);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key=' . $serverKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //Send the request 
    $response = curl_exec($ch);
    // dd($response);
}

