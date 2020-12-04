<?php

namespace App\Http\Controllers;

use App\Grouped;
use App\Logger;
use App\Subcategory;
use Illuminate\Http\Request;

class GroupedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategory = Subcategory::orderBy('created_at')->get();
        $data = Grouped::with(['admin','subcategory'])->orderBy('gr_state')->orderBy('created_at')->get();
        return view('pages.grouped.index',['data'=>$data,'subcategory'=>$subcategory]);
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
            'subcategory' => 'required|exists:subcategories,id',
            'imgs' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
        ]);
        $grouped = new Grouped;
        $grouped->gr_name = $request->name;
        $grouped->gr_name_ku = $request->name_kurdish;
        $grouped->gr_name_ar = $request->name_arabic;
        $grouped->gr_name_pr = $request->name_persian;
        $grouped->gr_name_kr = $request->name_kurmanji;
        $grouped->gr_subcategory = $request->subcategory;
        $grouped->gr_image = $request->imgs->store('uploads', 'public');
        $grouped->gr_state =  $request->state == 'on' ? 1 : 0;
        $grouped->gr_admin = session('dashboard');
        $grouped->save();
        Logger::create([
            'log_name' => 'Grouped',
            'log_action' =>'Create',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($grouped->toArray())]);
        return redirect()->back()->withSuccess('Added Grouped Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grouped  $grouped
     * @return \Illuminate\Http\Response
     */
    public function show(Grouped $grouped)
    {
        if (is_null($grouped)) return response()->json([
            'message' => 'grouped not found',
            'errors' => [
                'grouped' => 'Wrong id'
            ]
        ], 404);
        return response()->json([
            'grouped' => $grouped
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grouped  $grouped
     * @return \Illuminate\Http\Response
     */
    public function edit(Grouped $grouped)
    {
        $grouped->gr_state = !$grouped->gr_state;
        $grouped->save();
        Logger::create([
            'log_name' => 'Grouped',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($grouped->toArray())]);
        return redirect()->back()->withSuccess('Updated Grouped Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grouped  $grouped
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grouped $grouped)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'subcategory' => 'required|exists:subcategories,id',
            'imgs' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
        ]);
        
        $grouped->gr_name = $request->name;
        $grouped->gr_name_ku = $request->name_kurdish;
        $grouped->gr_name_ar = $request->name_arabic;
        $grouped->gr_name_pr = $request->name_persian;
        $grouped->gr_name_kr = $request->name_kurmanji;
        $grouped->gr_subcategory = $request->subcategory;
        $grouped->gr_image = isset($request->imgs)  ? $request->imgs->store('uploads', 'public')     : $grouped->gr_image;
        $grouped->gr_state =   $request->state == 'on' ? 1 : 0;
        $grouped->gr_admin = session('dashboard');
        $grouped->save();
        Logger::create([
            'log_name' => 'Grouped',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($grouped->toArray()),]);
        return redirect()->back()->withSuccess('Updated Grouped Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grouped  $grouped
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grouped $grouped)
    {
        try {
            $grouped->delete();
            Logger::create([
                'log_name' => 'Grouped',
                'log_action' =>'Delete',
                'log_admin' => session('dashboard'),
                'log_info'=> json_encode($grouped->toArray())]);
            return redirect()->back()->withSuccess('Deleted Grouped Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['er'=>'Maybe has relation !']);
        }
    }
}
