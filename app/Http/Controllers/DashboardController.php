<?php

namespace App\Http\Controllers;

use App\Article;
use App\Cart;
use App\Logger;
use App\Product;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class DashboardController extends Controller
{
    public function home()
    {
        return view('pages.index');
    }
    public function terms()
    {
        $data = Article::findOrfail(1);
        return view('pages.terms',['data'=>$data]);

    }
    public function index()
    {
        $month = [
            "January" => 0,
            "February" => 0,
            "March" => 0,
            "April" => 0,
            "May" => 0,
            "June" => 0,
            "July" => 0,
            "August" => 0,
            "September" => 0,
            "October" => 0,
            "November" => 0,
            "December" => 0,
        ];
        $setting = Setting::first();
        $user = User::where('u_role', 'USER')->whereDate('created_at', date('Y-m-d'))->get();
        $company = User::where('u_role', 'COMPANY')->whereDate('created_at', date('Y-m-d'))->get();
        $order = Cart::where('c_state', 1)->whereDate('created_at', date('Y-m-d'))->get();
        $product = Product::where('p_state', 1)->whereDate('created_at', date('Y-m-d'))->get();
        $top_company =  User::with(['company'])->withCount('product')->orderBy('product_count', 'desc')->has('product')->where('u_role', 'COMPANY')->get();
        $order_year = Cart::select(
            DB::raw('sum(c_price_all) as amount'),
            DB::raw("DATE_FORMAT(created_at,'%M') as months")
        )->where('c_state', 1)
            ->groupBy('months')
            ->get();
        foreach ($order_year as $key => $value) {
            $month[$value->months] = $value->amount;
        }
        $trending = Cart::with(['product'])
            ->where('c_state', 1)
            ->whereDate('created_at', date('Y-m-d'))
            ->groupBy('c_product')
            ->select('c_product', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->get();
        return view(
            'pages.dashboard.index',
            [
                'setting' => $setting,
                'user' => count($user),
                'product' => count($product),
                'company' => count($company),
                'order' => count($order),
                'profit' => $order,
                'trending' => $trending,
                'top_company' => $top_company,
                'chart' => json_encode($month, true),
            ]
        );
    }
    public function show(Request $request)
    {
        $month = [
            "January" => 0,
            "February" => 0,
            "March" => 0,
            "April" => 0,
            "May" => 0,
            "June" => 0,
            "July" => 0,
            "August" => 0,
            "September" => 0,
            "October" => 0,
            "November" => 0,
            "December" => 0,
        ];
        $timestamp = strtotime($request->date);
        $setting = Setting::first();
        $user = User::where('u_role', 'USER')->whereDate('created_at', $request->date)->get();
        $company = User::where('u_role', 'COMPANY')->whereDate('created_at', $request->date)->get();
        $order = Cart::where('c_state', 1)->whereDate('created_at', $request->date)->get();
        $product = Product::where('p_state', 1)->whereDate('created_at', $request->date)->get();
        $top_company =  User::with(['company'])->withCount('product')->orderBy('product_count', 'desc')->has('product')->where('u_role', 'COMPANY')->get();
        $order_year = Cart::select(
            DB::raw('sum(c_price_all) as amount'),
            DB::raw("DATE_FORMAT(created_at,'%M') as months")
        )->where('c_state', 1)
            ->whereYear('created_at', date('Y', $timestamp))
            ->groupBy('months')
            ->get();
        foreach ($order_year as $key => $value) {
            $month[$value->months] = $value->amount;
        }
        $trending = Cart::with(['product'])
            ->where('c_state', 1)
            ->whereDate('created_at', $request->date)
            ->groupBy('c_product')
            ->select('c_product', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')

            ->get();
        return view(
            'pages.dashboard.index',
            [
                'setting' => $setting,
                'user' => count($user),
                'product' => count($product),
                'company' => count($company),
                'order' => count($order),
                'profit' => $order,
                'trending' => $trending,
                'top_company' => $top_company,
                'chart' => json_encode($month, true),
                'date' => $request->date
            ]
        );
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
