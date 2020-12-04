<?php

namespace App\Http\Controllers;

use App\Bizzpayment;
use App\Logger;
use Illuminate\Http\Request;

class BizzpaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Bizzpayment::with('admin')->orderBy('created_at', 'DESC')->get();
        return view('pages.bizzcoin.index', ['data' => $data]);
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
            'price' => 'required|numeric|gte:0',
            'state' => 'sometimes|in:on,null',
        ]);
        $old = Bizzpayment::orderBy('created_at', 'DESC')->first();
        $bizzcoin = new Bizzpayment;
        $bizzcoin->bz_price = $request->price;
        $bizzcoin->bz_trading = is_null($old) ? 1 : ($old->bz_price > $request->price ? 0 : 1);
        $bizzcoin->bz_state =  $request->state == 'on' ? 1 : 0;
        $bizzcoin->bz_admin = session('dashboard');
        $bizzcoin->save();
        Logger::create([
            'log_name' => 'Bizzpayment',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($bizzcoin->toArray())
        ]);
        return redirect()->back()->withSuccess('Added Bizzpayment Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bizzcoin = Bizzpayment::findOrFail($id);

        $bizzcoin->bz_state = !$bizzcoin->bz_state;
        $bizzcoin->save();
        Logger::create([
            'log_name' => 'Bizzpayment',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($bizzcoin->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Bizzpayment Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $bizzcoin = Bizzpayment::findOrFail($id);
            $bizzcoin->delete();
            Logger::create([
                'log_name' => 'Bizzpayment',
                'log_action' => 'Delete',
                'log_admin' => session('dashboard'),
                'log_info' => json_encode($bizzcoin->toArray())
            ]);
            return redirect()->back()->withSuccess('Deleted Bizzpayment Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['er' => 'Maybe has relation !']);
        }
    }
}
