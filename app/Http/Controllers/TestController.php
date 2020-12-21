<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Test;
use Nexmo\Laravel\Facade\Nexmo;

class TestController extends Controller
{
    public function test(Request $request)
    {
        Nexmo::message()->send([
            'to'   => "+9647501594292",
            'from' => 'BizzPayment',
            'text' => 'Slaw Bram'
        ]);
        return 'OK';
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
