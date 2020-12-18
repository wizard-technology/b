<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Logger;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::with(['user'])->select(DB::raw('sum(c_price_all) as c_price_all,c_doc_id,sum(c_amount) as c_amount,MAX(created_at) as created_at,MAX(updated_at) as updated_at,MAX(c_state) as c_state,MAX(c_user) as c_user'))
            ->where('c_state', 2)
            ->where('c_type', 0)

            ->groupBy('c_doc_id')
            ->get();
        return view('pages.order.pending', [
            'data' => $cart
        ]);
    }
    public function finished()
    {
        $cart = Cart::with(['user'])->select(DB::raw('sum(c_price_all) as c_price_all,c_doc_id,sum(c_amount) as c_amount,MAX(created_at) as created_at,MAX(updated_at) as updated_at,MAX(c_state) as c_state,MAX(c_user) as c_user'))
            ->where('c_state', 1)
            ->where('c_type', 0)

            ->groupBy('c_doc_id')
            ->get();

        return view('pages.order.finished', ['data' => $cart]);
    }
    public function rejected()
    {
        $cart = Cart::with(['user'])->select(DB::raw('sum(c_price_all) as c_price_all,c_doc_id,sum(c_amount) as c_amount,MAX(created_at) as created_at,MAX(updated_at) as updated_at,MAX(c_state) as c_state,MAX(c_user) as c_user'))
            ->where('c_state', 3)
            ->where('c_type', 0)
            ->groupBy('c_doc_id')
            ->get();
        return view('pages.order.rejected', ['data' => $cart]);
    }
    public function accept()
    {
        $cart = Cart::with(['user'])->select(DB::raw('sum(c_price_all) as c_price_all,c_doc_id,sum(c_amount) as c_amount,MAX(created_at) as created_at,MAX(updated_at) as updated_at,MAX(c_state) as c_state,MAX(c_user) as c_user'))
            ->where('c_state', 4)
            ->where('c_type', 0)
            ->groupBy('c_doc_id')
            ->get();
        return view('pages.order.accept', ['data' => $cart]);
    }
    public function cart_delete(Request $request, $id)
    {
        $cart = Cart::where('c_doc_id', $id);
        Logger::create([
            'log_name' => 'Order',
            'log_action' => 'Delete',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($cart->get()->toArray())
        ]);
        $cart->delete();
        return redirect()->back()->withSuccess('Deleted Order in Cart Successfully !');
    }
    public function change_state($id, $type)
    {
        $cart = Cart::with('user')->where('c_doc_id', $id)->where('c_type', 0);
        $notification = new Notification;
        $notification->noti_content = 'content';
        $notification->noti_id_opened = $id;
        switch ($type) {
            case 'finish':
                $cart->update(['c_state' => 1]);
                $cart2 = $cart->get();
                $notification->noti_title = 'Your order has been Finished, Thank you';
                $notification->noti_type = 1;
            sendFirebaseMessage($cart2[0]->user->u_firebase,'Order Finish','Your Order Number #'.$cart2[0]->c_doc_id.' Finish');

                break;
            case 'reject':
                $cart->update(['c_state' => 3]);
                $cart2 = $cart->get();
                $notification->noti_title = 'Your order has been Rejected';
                $notification->noti_type = 3;
            sendFirebaseMessage($cart2[0]->user->u_firebase,'Order Rejected','Your Order Number #'.$cart2[0]->c_doc_id.' Rejected');

                break;
            case 'accept':
                $cart->update(['c_state' => 4]);
                $cart2 = $cart->get();
                $notification->noti_title = 'Your order has been Accepted, we contact you soon.';
                $notification->noti_type = 4;
            sendFirebaseMessage($cart2[0]->user->u_firebase,'Order Accepted','Your Order Number #'.$cart2[0]->c_doc_id.' Accepted');

                break;
            default:
                $cart->update(['c_state' => 2]);
                $cart2 = $cart->get();
                $notification->noti_title = 'Your order has been Pending, please wait';
                $notification->noti_type = 2;
            // sendFirebaseMessage($cart[0]->user->u_firebase,'Order Pendding','');

                break;
        }
        $notification->noti_user = $cart->get()[0]->c_user;
        $notification->save();
        Logger::create([
            'log_name' => 'Cart',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($cart->get()->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Order in Cart Successfully !');
    }
    // public function card()
    // {
    //     $cart = Cart::with(['user'])->select(DB::raw('sum(c_price_all) as c_price_all,c_doc_id,sum(c_amount) as c_amount,MAX(created_at) as created_at,MAX(updated_at) as updated_at,MAX(c_state) as c_state,MAX(c_user) as c_user'))
    //     ->where('c_state',2)
    //     ->groupBy('c_doc_id')
    //     ->get();
    //     return view('pages.order.card', []);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::with(['user', 'product'])->where('c_doc_id', $id)->get();
        return view('pages.order.show', ['data' => $cart]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        Logger::create([
            'log_name' => 'Cart',
            'log_action' => 'Delete',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($cart->toArray())
        ]);
        return redirect()->back()->withSuccess('Deleted Product in Cart Successfully !');
    }
}
