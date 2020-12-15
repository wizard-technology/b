<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $nonce = time();
        $access_key = "d671bbb1c3b41eec";
        $secret_key = "bb32e10326e8d5a345b5b59b6aeabe37";
        $sig = hash_hmac('SHA256', $nonce . $access_key, $secret_key);
        dd($nonce,$access_key,$sig);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://bizz.exchange/api/v2/peatio/account/latest/deposit_address");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            [
                "currency" => "bizz",
                "amount" =>0.01,
                "callback_url" => "callback_url",
                "web_hook_url" => route('web_hook'),
                "remarks" => '2112',
                "user_id" => '12123'
            ]
        ));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'cache-control: no-cache',
            'content-type: multipart/form-data',
            'X-Auth-Apikey:' . $access_key,
            'X-Auth-Nonce:' . $nonce,
            'X-Auth-Signature:' . $sig,
        ]);

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
        dd($result);
        $data = "BIZZ:".json_decode($result)->address."?amount=0.0001";
        $qrCode = new \Endroid\QrCode\QrCode($data);
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $dataUri = $qrCode->writeDataUri();
        return response()->json(json_decode($result), 200);
    }
    public function web_hook(Request $request)
    {
        Storage::put('file.txt', $request->input());
        return 1;
    }
}
