<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Logger;
use App\Product;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class DashboardController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $user = User::where('u_role', 'USER')->whereDate('created_at', date('Y-m-d'))->get();
        $company = User::where('u_role', 'COMPANY')->whereDate('created_at', date('Y-m-d'))->get();
        $order = Cart::where('c_state', 1)->whereDate('created_at', date('Y-m-d'))->get();
        $product = Product::where('p_state', 1)->whereDate('created_at',date('Y-m-d'))->get();

        return view('pages.dashboard.index', ['setting' => $setting, 'user' => count($user), 'product' => count($product), 'company' => count($company), 'order' => count($order)]);
    }
    public function show(Request $request)
    {
        $setting = Setting::first();
        $user = User::where('u_role', 'USER')->whereDate('created_at', $request->date)->get();
        $company = User::where('u_role', 'COMPANY')->whereDate('created_at', $request->date)->get();
        $order = Cart::where('c_state', 1)->whereDate('created_at', $request->date)->get();
        $product = Product::where('p_state', 1)->whereDate('created_at', $request->date)->get();
        return view('pages.dashboard.index', ['setting' => $setting, 'user' => count($user), 'product' => count($product), 'company' => count($company), 'order' => count($order), 'date' => $request->date]);
    }

    public function test(Request $request)
    {

        return 1;
        // return getIpAddress();
    }
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);
        $tr = new GoogleTranslate();
        $tr->setSource('en');
        $tr->setTarget('ar');
        $ar =  $tr->translate($request->text);
        $ar_info =  isset($request->info) ? $tr->translate($request->info) : '';
        $tr->setTarget('fa');
        $pr =  $tr->translate($request->text);
        $pr_info =  isset($request->info) ? $tr->translate($request->info) : '';
        $tr->setTarget('ku');
        $kr =  $tr->translate($request->text);
        $kr_info =  isset($request->info) ? $tr->translate($request->info) : '';

        return response()->json([
            'ar' => $ar,
            'pr' => $pr,
            'kr' => $kr,
            'ar_info' => $ar_info,
            'pr_info' => $pr_info,
            'kr_info' => $kr_info,
        ], 200);
    }
}
