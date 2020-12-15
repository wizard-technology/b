<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Test;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $nonce = time();
        $access_key = env("BIZZCOIN_KEY");
        $secret_key =  env("BIZZCOIN_SECRET");
        $sig = hash_hmac('SHA256', $nonce . $access_key, $secret_key);
        dd($nonce,$access_key,$sig);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env("BIZZCOIN_LINK"));
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
        // dd($request->input());
        $test = new Test;
        $test->data =  json_encode($request->input());
        $test->save();
        return response()->json('OKEY', 200);

    }
}
