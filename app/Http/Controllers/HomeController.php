<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use App\Bizzpayment;
use App\Cardinfo;
use App\Cart;
use App\Company;
use App\Favorite;
use App\Grouped;
use App\hasinfoProductCart;
use App\Help;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Product;
use App\Productcompany;
use App\Producttag;
use App\RedeemCode;
use App\Setting;
use App\Subcategory;
use App\Test;
use App\Type;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $product = Product::with('extra')->where('p_state', 1)->orderBy('p_order_by')->paginate(10);
        $type = Type::where('t_state', 1)->orderBy('id', 'DESC')->get();
        return response()->json([
            'product' => $product,
            'type' => $type,
        ], 200);
    }
    public function isNotificationAndCheckout(Request $request)
    {
        $cart = Cart::where('c_user', $request->user()->id)->where('c_state', 0)->get()->count();
        $notification = Notification::where('noti_user', $request->user()->id)->where('noti_state', 0)->get()->count();
        return response()->json([
            'cart' =>  $cart > 0,
            'notification' => $notification > 0,
        ], 200);
    }
    public function openNotification(Request $request)
    {
        $notification = Notification::where('noti_user', $request->user()->id);
        $notification->update(['noti_state' => 1]);
        return response()->json([
            'notification' => $notification->orderBy('created_at', 'DESC')->get(),
        ], 200);
    }
    public function getSubcategory($id)
    {
        $subcategory = Subcategory::where('st_state', 1)->where('st_type', $id)->orderBy('id', 'DESC')->get();
        return response()->json([
            'subcategory' => $subcategory
        ], 200);
    }
    public function getGrouped($id)
    {
        $grouped = Grouped::where('gr_state', 1)->where('gr_subcategory', $id)->orderBy('id', 'DESC')->get();
        return response()->json([
            'grouped' => $grouped
        ], 200);
    }
    public function getProduct($id)
    {
        $product = Product::with('extra')->where('p_state', 1)->where('p_grouped', $id)->orderBy('p_order_by')->paginate(10);
        return response()->json([
            'product' => $product
        ], 200);
    }
    public function getByType($type)
    {
        $product = Product::where('p_state', 1)->where('p_type', $type)->orderBy('p_order_by')->paginate(10);
        return response()->json([
            'product' => $product,
        ], 200);
    }
    public function getBySubcategory($subcategory)
    {
        $product = Product::where('p_state', 1)->where('p_subcategory', $subcategory)->orderBy('p_order_by')->paginate(10);
        return response()->json([
            'product' => $product,
        ], 200);
    }
    public function types(Request $request)
    {
        $type = Type::where('t_state', 1)->orderBy('id', 'DESC')->get();
        return response()->json([
            'type' => $type
        ], 200);
    }
    public function subcategories(Request $request)
    {
        $subcategory = Subcategory::where('st_state', 1)->orderBy('id', 'DESC')->get();
        return response()->json([
            'subcategory' => $subcategory
        ], 200);
    }
    public function product($id)
    {
        $product = Product::with(['tags.tagName', 'extra'])->where('p_state', 1)->orderBy('p_order_by')->find($id);
        $bizz = Setting::orderBy('id', 'DESC')->first();

        $tags = [];
        foreach ($product->tags as $key => $value) {
            array_push($tags, $value->pt_tag);
        }

        $recomanded = Producttag::with(['product'])->whereIn('pt_tag', $tags)->where('pt_product', '<>', $id)->get();

        return response()->json([
            'product' => $product,
            'recomanded' =>  $recomanded->unique('product')->values()->all(),
            'dinar' =>  $bizz->dinar * $product->p_price,
            'bizzcoin' => (1 / $bizz->bizzcoin) * $product->p_price
        ], 200);
    }
    public function productUser(Request $request, $id)
    {
        $product = Product::with(['tags.tagName', 'extra'])->where('p_state', 1)->orderBy('p_order_by')->find($id);
        $fav = Favorite::where('fa_user', $request->user()->id)->where('fa_product', $id)->first() == null ? false : true;
        $bizz = Setting::orderBy('id', 'DESC')->first();

        $tags = [];
        foreach ($product->tags as $key => $value) {
            array_push($tags, $value->pt_tag);
        }

        $recomanded = Producttag::with(['product.extra'])->whereIn('pt_tag', $tags)->where('pt_product', '<>', $id)->get();
        return response()->json([
            'product' => $product,
            'favorate' =>  $fav,
            'recomanded' =>  $recomanded->unique('product')->values()->all(),
            'dinar' =>  $bizz->dinar * $product->p_price,
            'bizzcoin' => (1 / $bizz->bizzcoin) * $product->p_price
        ], 200);
    }
    public function favorate(Request $request, $id)
    {
        $fav = Favorite::where('fa_user', $request->user()->id)->where('fa_product', $id)->first();

        if (is_null($fav)) {
            $favorate = new Favorite;
            $favorate->fa_user =  $request->user()->id;
            $favorate->fa_product =  $id;
            $favorate->save();
            $fav = true;
        } else {
            $fav->delete();
            $fav = false;
        }
        return response()->json([
            'favorate' =>  $fav,

        ], 200);
    }
    public function favorateGet(Request $request)
    {
        $fav = Favorite::with('product')->where('fa_user', $request->user()->id)->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'favorate' =>  $fav,
        ], 200);
    }
    public function cartGet(Request $request)
    {
        $cart = Cart::with('product')->where('c_user', $request->user()->id)->where('c_state', 0)->orderBy('created_at', 'DESC')->get();
        $bizz = Setting::orderBy('id', 'DESC')->first();
        return response()->json([
            'cart' =>  $cart,
            'total' => $cart->sum('c_price_all') / $bizz->bizzcoin,
            'dollar' => $cart->sum('c_price_all'),
            'dinar' =>  $bizz->dinar,
            'bizzcoin' => $bizz->bizzcoin

        ], 200);
    }
    public function bizzcoin()
    {
        $bizz = Setting::orderBy('id', 'DESC')->first();
        $bizzcoin = Bizzpayment::where('bz_state', 1)->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'now' =>  $bizz->bizzcoin,
            'dinar' =>  $bizz->dinar,
            'bizzcoin' =>  $bizzcoin,
        ], 200);
    }
    public function terms()
    {
        $term = Article::findOrFail(1);
        return response()->json([
            'term' =>  json_decode($term),
        ], 200);
    }
    public function sendReport(Request $request)
    {
        $request->validate([
            'information' => 'required|string|max:1000|min:20',
        ]);
        // $last_report = Help::where('h_user', auth()->user()->id)->where('h_from', 0)->orderBy('created_at', 'DESC')->first();
        // if (!is_null($last_report)) {
        //     $last = Carbon::parse($last_report->created_at)->addDay();
        //     $now = Carbon::parse(now());
        //     $diff = $last->diff($now);
        //     if ($last  < $now) {
        // $help = new Help;
        // $help->h_info = $request->information;
        // $help->h_user = $request->user()->id;
        // $help->save();

        // return response()->json([
        //     'message' =>  ['Thank you to your feedback'],
        // ], 200);
        // }

        // return response()->json([
        //     'message' => 'Cool down sending report',
        //     'errors' => [
        //         'information' => ['Please wait still ' . $diff->format('%h:%i:%s') . ' to next report']
        //     ],
        // ], 401);
        // }

        $help = new Help;
        $help->h_info = $request->information;
        $help->h_user = $request->user()->id;
        $help->save();

        return response()->json([
            'message' =>  ['Thank you to your feedback'],
        ], 200);
    }
    public function getReport(Request $request)
    {
        Help::where('h_user', $request->user()->id)->where('h_state', 0)->where('h_from', '<>', 0)->update(['h_state' => 1]);
        $report = Help::where('h_user', auth()->user()->id)->orderBy('created_at')->limit(30)->get();
        return response()->json([
            'report' => $report
        ], 200);
    }
    public function getRedeem(Request $request)
    {

        $redeem = RedeemCode::with('company.company')->where('rc_user', auth()->user()->id)->orderBy('rc_state')->limit(30)->get();
        return response()->json([
            'redeem' => $redeem
        ], 200);
    }
    public function addToCart(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
        ]);

        $data = Cart::where('c_user', $request->user()->id)->where('c_product', $request->product)->where('c_state', 0)->first();

        if ($data == null) {
            $product = Product::find($request->product);
            $doc_num = 1;

            $cart = Cart::orderBy('c_doc_id', 'DESC')->first();
            is_null($cart) ? $doc_num  : $doc_num = $cart->c_doc_id + 1;

            $my_cart = Cart::with(['product'])->where('c_user', $request->user()->id)->where('c_state', 0)->first();
            is_null($my_cart) ? $doc_num  : $doc_num = $my_cart->c_doc_id;

            if (!is_null($my_cart)) {
                if ($my_cart->product->p_type != $product->p_type) {
                    return response()->json([
                        'message' =>  ['Please Only one type must in Cart'],
                    ], 200);
                }
            }
            $cart = new Cart;
            $cart->c_amount = 1;
            $cart->c_state = 0;
            $cart->c_price =  $product->p_price;
            $cart->c_price_all =  $product->p_price;
            $cart->c_doc_id =  $doc_num; //GG
            $cart->c_product =  $product->id;
            if ($product->p_has_info == 1) {
                $cart->c_type =  1;
            }
            $cart->c_user = $request->user()->id;
            $cart->save();
            return response()->json([
                'message' =>  ['You Added to cart'],
            ], 200);
        } else {
            return response()->json([
                'message' =>  ['Your Item Already in cart'],
            ], 200);
        }
    }
    public function cartDelete(Request $request)
    {
        $request->validate([
            'doc' => 'required|in:' . implode(',', Cart::select('id')->where('c_state', 0)->where('c_user',  $request->user()->id)->pluck('id')->toArray()),
        ]);
        $cart = Cart::find($request->doc);
        $cart->delete();
        $cart = Cart::with('product')->where('c_user', $request->user()->id)->where('c_state', 0)->orderBy('created_at', 'DESC')->get();
        $bizz = Setting::orderBy('id', 'DESC')->first();

        return response()->json([
            'message' =>  ['Deleted successfuly'],
            'total' => $cart->sum('c_price_all') / $bizz->bizzcoin,
            'dinar' =>  $bizz->dinar,
            'bizzcoin' => $bizz->bizzcoin
        ], 200);
    }
    public function amountChange(Request $request)
    {
        $request->validate([
            'doc' => 'required|in:' . implode(',', Cart::select('id')->where('c_state', 0)->where('c_user',  $request->user()->id)->pluck('id')->toArray()),
            'tran' => 'required|in:p,m'
        ]);
        $cart = Cart::find($request->doc);
        if ($request->tran == 'p') {
            $cart->c_amount = $cart->c_amount + 1;
            $cart->c_price_all = $cart->c_price * $cart->c_amount;
            $cart->save();
        } else {
            if ($cart->c_amount  > 1) {
                $cart->c_amount = $cart->c_amount - 1;
                $cart->c_price_all = $cart->c_price * $cart->c_amount;
                $cart->save();
            }
        }
        $total = Cart::where('c_user', $request->user()->id)->where('c_state', 0)->get();
        $bizz = Setting::orderBy('id', 'DESC')->first();
        return response()->json([
            'message' =>  ['Changed successfuly'],
            'cart' => $cart,
            'total' => $total->sum('c_price_all') / $bizz->bizzcoin,
            'dollar' => $total->sum('c_price_all'),
            'dinar' =>  $bizz->dinar,
            'bizzcoin' => $bizz->bizzcoin
        ], 200);
    }
    public function onSearch($text)
    {

        $product = Product::with('extra')->select(['id', 'p_name', 'p_name_ku', 'p_name_ar', 'p_name_pr', 'p_name_kr', 'p_price', 'p_image'])
            ->where(function ($query) use ($text) {
                $query->where('p_name', 'like', '%' . $text . '%');
                $query->orWhere('p_name_ku', 'like', '%' . $text . '%');
                $query->orWhere('p_name_ar', 'like', '%' . $text . '%');
                $query->orWhere('p_name_pr', 'like', '%' . $text . '%');
                $query->orWhere('p_name_kr', 'like', '%' . $text . '%');
            })
            ->where('p_state', 1)
            ->orderBy('p_order_by')
            ->paginate(8);
        return response()->json([
            'product' => $product,
        ], 200);
    }
    public function checkOut(Request $request)
    {
        // $cart = Cart::with(['product'])->where('c_user', $request->user()->id)->where('c_state', 0)->get();
        // foreach ($cart as $key => $value) {
        //     if ($value->product->p_has_info) {
        //         $ci = Cardinfo::where('ci_product', $value->product->id)->where('ci_state', 1)->count();
        //         if ($ci < $value->c_amount) {
        //             return response()->json([
        //                 'product' => $value->product,
        //                 'error' => 'Out Of Stuck'
        //             ], 200);
        //         }
        //     }
        // }
        // foreach ($cart as $key => $value) {
        //     if ($value->product->p_has_info) {
        //         for ($i = 0; $i < $value->c_amount; $i++) {
        //             $card = Cardinfo::where('ci_product', $value->product->id)->where('ci_state', 1)->first();
        //             $checkout = new hasinfoProductCart;
        //             $checkout->hpc_order = $value->c_doc_id;
        //             $checkout->hpc_user =  $value->c_user;
        //             $checkout->hpc_cardinfo =  $card->id;
        //             $checkout->save();
        //             $card->ci_state = 2;
        //             $card->save();
        //         }
        //         $value->c_state = 1;
        //         $value->save();
        //     } else {
        //         $value->c_state = 2;
        //         $value->save();
        //     }
        // }
        // return response()->json([
        //     'product' => "Done",
        // ], 200);
    }
    public function company()
    {
        $company = User::with(['company', 'city'])->where('u_role', 'COMPANY')->where('u_state', 1)->get();
        return response()->json([
            'company' => $company,
        ], 200);
    }
    public function cartGroup(Request $request)
    {
        $cart =  DB::table('carts')
            ->where('c_user', $request->user()->id)
            ->where('c_state', '<>', 0)
            ->select('c_doc_id', 'created_at', DB::raw('sum(c_price_all) as price'))
            ->groupBy('c_doc_id', 'created_at')
            ->get();
        return response()->json([
            'cart' => $cart,
        ], 200);
    }
    public function cartFinished(Request $request, $cart)
    {
        $product = hasinfoProductCart::with(['info.product'])->where('hpc_user', $request->user()->id)->where('hpc_order', $cart)->get();
        $type = true;
        if ($product->isEmpty()) {
            $product = Cart::with(['product'])->where('c_doc_id', $cart)->get();
            $type = false;
        }
        $bizz = Setting::orderBy('id', 'DESC')->first();
        return response()->json([
            'product' => $product,
            'dinar' =>  $bizz->dinar,
            'bizzcoin' => $bizz->bizzcoin,
            'type' => $type,
        ], 200);
    }
    public function getProductCompany($id)
    {
        $company = Company::find($id);
        $product = Productcompany::with('images')->where('pc_company', $company->co_user)->get();
        return response()->json([
            'product' => $product
        ], 200);
    }
    public function checkOutRedeem(Request $request)
    {

        return response()->json([
            'product' => $product
        ], 200);
    }
    public function payment(Request $request)
    {
        $cart = Cart::with(['product'])->where('c_user', $request->user()->id)->where('c_state', 0)->get();
        foreach ($cart as $key => $value) {
            if ($value->product->p_has_info) {
                $ci = Cardinfo::where('ci_product', $value->product->id)->where('ci_state', 1)->count();
                if ($ci < $value->c_amount) {
                    return response()->json([
                        'product' => $value->product,
                        'error' => 'Out Of Stuck'
                    ], 401);
                }
            }
        }
        $cart = Cart::with('product')->where('c_user', $request->user()->id)->where('c_state', 0)->orderBy('created_at', 'DESC')->get();
        $bizz = Setting::orderBy('id', 'DESC')->first()->bizzcoin;

        $nonce = time();
        $access_key = "d671bbb1c3b41eec";
        $secret_key =  "bb32e10326e8d5a345b5b59b6aeabe37";
        $sig = hash_hmac('SHA256', $nonce . $access_key, $secret_key);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://bizz.exchange/api/v2/peatio/account/latest/deposit_address");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            [
                "currency" => "bizz",
                "amount" => round($cart->sum('c_price_all') / $bizz, 8),
                "callback_url" => route('web_hook'),
                "web_hook_url" => route('web_hook'),
                "remarks" => $cart[0]->c_doc_id,
                "user_id" =>  $request->user()->id
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
        $data = "BIZZ:" . json_decode($result)->address . "?amount=" . round($cart->sum('c_price_all') / $bizz, 8);
        $qrCode = new \Endroid\QrCode\QrCode($data);
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $dataUri = $qrCode->writeDataUri();
        return response()->json([
            'result' => $result,
            'qr' => saveImageBase64($dataUri)
        ], 200);
    }
    public function payment_redeem(Request $request)
    {
        $request->validate([
            'company' => 'required|exists:users,id',
            'amount' => 'required|numeric|gt:0',
        ]);
        $bizz = Setting::orderBy('id', 'DESC')->first()->bizzcoin;

        $nonce = time();
        $access_key = "d671bbb1c3b41eec";
        $secret_key =  "bb32e10326e8d5a345b5b59b6aeabe37";
        $sig = hash_hmac('SHA256', $nonce . $access_key, $secret_key);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://bizz.exchange/api/v2/peatio/account/latest/deposit_address");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
            [
                "currency" => "bizz",
                "amount" => round($request->amount / $bizz, 8),
                "callback_url" => route('web_hook.redeem'),
                "web_hook_url" => route('web_hook.redeem'),
                "remarks" =>    $request->company,
                "user_id" =>  $request->user()->id
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

        $data = "BIZZ:" . json_decode($result)->address . "?amount=" . round($request->amount / $bizz, 8);
        $qrCode = new \Endroid\QrCode\QrCode($data);
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $dataUri = $qrCode->writeDataUri();

        return response()->json([
            'result' => $result,
            'dollar' => $request->amount,
            'bizz' => $request->amount / $bizz,
            'qr' => saveImageBase64($dataUri)
        ], 200);
    }
    public function web_hook(Request $request)
    {
        $user = User::findOrFail($request->header('user-id'));
        $test = new Test();
        $test->data =  json_encode($request->header());
        $test->save();
        if ($request->input('status') == 'succeed') {
            $cart = Cart::with(['product'])->where('c_doc_id', $request->header('order-id'))->where('c_state', 0)->get();
            if (!$cart->isEmpty()) {
                foreach ($cart as $key => $value) {
                    if ($value->product->p_has_info) {
                        $ci = Cardinfo::where('ci_product', $value->product->id)->where('ci_state', 1)->count();
                        if ($ci < $value->c_amount) {
                            return response()->json([
                                'product' => $value->product,
                                'error' => 'Out Of Stuck'
                            ], 200);
                        }
                    }
                }

                foreach ($cart as $key => $value) {
                    if ($value->product->p_has_info) {
                        for ($i = 0; $i < $value->c_amount; $i++) {
                            $card = Cardinfo::where('ci_product', $value->product->id)->where('ci_state', 1)->first();
                            $checkout = new hasinfoProductCart;
                            $checkout->hpc_order = $value->c_doc_id;
                            $checkout->hpc_user =  $value->c_user;
                            $checkout->hpc_cardinfo =  $card->id;
                            $checkout->save();
                            $card->ci_state = 2;
                            $card->save();
                        }
                        $value->c_state = 1;
                        $value->save();
                    } else {
                        $value->c_state = 2;
                        $value->save();
                    }
                }

                $notification = new Notification;
                $notification->noti_content = 'content';
                $notification->noti_id_opened = $request->header('order-id');
                $notification->noti_user = $user->id;
                $notification->noti_title = 'Your order has been Finished.';
                $notification->noti_type = 4;
                sendFirebaseMessage($user->u_firebase, 'Order Finished', 'Your Order Number #' .  $request->header('order-id') . ' Finished', ['history' =>  $request->header('order-id')]);
            } else {
                $notification = new Notification;
                $notification->noti_content = 'content';
                $notification->noti_id_opened = $request->header('order-id');
                $notification->noti_user = $user->id;
                $notification->noti_title = 'Failed Transaction';
                $notification->noti_type = 3;
                sendFirebaseMessage($user->u_firebase, 'Order Failed', 'Your Order Number #' .  $request->header('order-id') . ' Failed', ['history' =>  $request->header('order-id')]);
            }
        }
    }
    public function web_hook_redeem(Request $request)
    {
        $user = User::findOrFail($request->header('user-id'));
        $test = new Test();
        $test->data =  json_encode($request->header());
        $test->save();
        if ($request->input('status') == 'succeed') {
            $data = uniqid() . uniqid();
            $qrCode = new \Endroid\QrCode\QrCode($data);
            $qrCode->setWriterByName('png');
            $qrCode->setEncoding('UTF-8');
            $dataUri = $qrCode->writeDataUri();
            $redeem = new RedeemCode;
            $redeem->rc_qrcode = saveImageBase64($dataUri);
            $redeem->rc_code = $data;
            $redeem->rc_currency = $request->input('currency');
            $redeem->rc_txid = $request->input('txid');
            $redeem->rc_price =  $request->input('amount');
            $redeem->rc_user = $request->header('user-id');
            $redeem->rc_company = $request->header('order-id');
            $redeem->rc_state = 0;
            $redeem->save();
        }
    }
}
