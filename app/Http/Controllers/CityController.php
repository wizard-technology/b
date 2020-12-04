<?php

namespace App\Http\Controllers;

use App\City;
use App\Logger;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = City::with('admin')->orderBy('ct_state')->orderBy('created_at')->get();
        return view('pages.city.index', ['data' => $data]);
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
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);
        $city = new City;
        $city->ct_name = $request->name;
        $city->ct_name_ku = $request->name_kurdish;
        $city->ct_name_ar = $request->name_arabic;
        $city->ct_name_pr = $request->name_persian;
        $city->ct_name_kr = $request->name_kurmanji;
        $city->ct_state =  $request->state == 'on' ? 1 : 0;
        $city->ct_admin = session('dashboard');
        $city->save();
        Logger::create([
            'log_name' => 'City',
            'log_action' =>'Create',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($city->toArray())]);
        return redirect()->back()->withSuccess('Added City Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $city->ct_state = !$city->ct_state;
        $city->save();
        Logger::create([
            'log_name' => 'City',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($city->toArray())]);
        return redirect()->back()->withSuccess('Updated City Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);

        $city->ct_name = $request->name;
        $city->ct_name_ku = $request->name_kurdish;
        $city->ct_name_ar = $request->name_arabic;
        $city->ct_name_pr = $request->name_persian;
        $city->ct_name_kr = $request->name_kurmanji;
        $city->ct_state =   $request->state == 'on' ? 1 : 0;
        $city->ct_admin = session('dashboard');
        $city->save();
        Logger::create([
            'log_name' => 'City',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($city->toArray())]);
        return redirect()->back()->withSuccess('Updated City Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        try {
            $city->delete();
            Logger::create([
                'log_name' => 'City',
                'log_action' =>'Delete',
                'log_admin' => session('dashboard'),
                'log_info'=> json_encode($city->toArray())]);
            return redirect()->back()->withSuccess('Deleted City Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['er' => 'Maybe has relation !']);
        }
    }
}
