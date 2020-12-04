<?php

namespace App\Http\Controllers;

use App\Cardinfo;
use App\Logger;
use App\Product;
use Illuminate\Http\Request;

class CardinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where('p_state', 1)->where('p_has_info', 1)->get();

        $data = Cardinfo::with(['product', 'admin'])->get();

        return view('pages.card.index', [
            'product' => $product,
            'data' => $data
        ]);
    }

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
        $request->validate([
            'code' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
            'product' => 'required|exists:products,id',
        ]);

        $card = new CardInfo;
        $card->ci_code = $request->code;
        $card->ci_state = $request->state == 'on' ? 1 : 0;
        $card->ci_product = $request->product;
        $card->ci_admin = session('dashboard');
        $card->save();
        Logger::create([
            'log_name' => 'Card Information',
            'log_action' =>'Create',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($card->toArray())]);
        return redirect()->back()->withSuccess('Added Card Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cardinfo  $cardinfo
     * @return \Illuminate\Http\Response
     */
    public function show(Cardinfo $cardinfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cardinfo  $cardinfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cardinfo = Cardinfo::findOrFail($id);
        if ($cardinfo->ci_state == 0 || $cardinfo->ci_state == 1) {
            $cardinfo->ci_state = !$cardinfo->ci_state;
            $cardinfo->save();
            Logger::create([
                'log_name' => 'Card Information',
                'log_action' =>'Update',
                'log_admin' => session('dashboard'),
                'log_info'=> json_encode($cardinfo->toArray())]);
            return redirect()->back()->withSuccess('Updated Card Successfully !');
        }
        return redirect()->back()->withErrors('Updated Card Faild !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cardinfo  $cardinfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cardinfo = Cardinfo::findOrFail($id);
        $request->validate([
            'code' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
            'product' => 'required|exists:products,id',
        ]);
            if ($cardinfo->ci_state == 0 || $cardinfo->ci_state == 1) {
            $cardinfo->ci_code = $request->code;
            $cardinfo->ci_state = $request->state == 'on' ? 1 : 0;
            $cardinfo->ci_product = $request->product;
            $cardinfo->save();
            Logger::create([
                'log_name' => 'Card Information',
                'log_action' =>'Update',
                'log_admin' => session('dashboard'),
                'log_info'=> json_encode($cardinfo->toArray())]);
            return redirect()->back()->withSuccess('Updated Card Successfully !');
        }
        return redirect()->back()->withErrors('Updated Card Faild !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cardinfo  $cardinfo
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $cardinfo = Cardinfo::findOrFail($id);
        $cardinfo->delete();
        Logger::create([
            'log_name' => 'Card Information',
            'log_action' =>'Delete',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($cardinfo->toArray())]);
        return redirect()->back()->withSuccess('Deleted Card Successfully !');

    }
}
