<?php

namespace App\Http\Controllers;

use App\Subcategory;
use App\Logger;
use App\Type;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Type::orderBy('created_at')->get();
        $data = Subcategory::with(['admin','category'])->orderBy('st_state')->orderBy('created_at')->get();
        return view('pages.subcategory.index',['data'=>$data,'type'=>$type]);
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
            'category' => 'required|exists:types,id',
            'imgs' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
        ]);
        $subcategory = new Subcategory;
        $subcategory->st_name = $request->name;
        $subcategory->st_name_ku = $request->name_kurdish;
        $subcategory->st_name_ar = $request->name_arabic;
        $subcategory->st_name_pr = $request->name_persian;
        $subcategory->st_name_kr = $request->name_kurmanji;
        $subcategory->st_type	 = $request->category;
        $subcategory->st_image = $request->imgs->store('uploads', 'public');
        $subcategory->st_state =  $request->state == 'on' ? 1 : 0;
        $subcategory->st_admin = session('dashboard');
        $subcategory->save();
        Logger::create([
            'log_name' => 'Subcategory',
            'log_action' =>'Create',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($subcategory->toArray())]);
        return redirect()->back()->withSuccess('Added Subcategory Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        if (is_null($subcategory)) return response()->json([
            'message' => 'subcategory not found',
            'errors' => [
                'subcategory' => 'Wrong id'
            ]
        ], 404);
        return response()->json([
            'subcategory' => $subcategory
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
       
        $subcategory->st_state = !$subcategory->st_state;
        $subcategory->save();
        Logger::create([
            'log_name' => 'Subcategory',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($subcategory->toArray())]);
        return redirect()->back()->withSuccess('Updated Subcategory Successfully !');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'category' => 'required|exists:types,id',
            'imgs' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
        ]);
        
        $subcategory->st_name = $request->name;
        $subcategory->st_name_ku = $request->name_kurdish;
        $subcategory->st_name_ar = $request->name_arabic;
        $subcategory->st_name_pr = $request->name_persian;
        $subcategory->st_name_kr = $request->name_kurmanji;
        $subcategory->st_type	 = $request->category;
        $subcategory->st_image = isset($request->imgs)  ? $request->imgs->store('uploads', 'public')     : $subcategory->st_image;
        $subcategory->st_state =   $request->state == 'on' ? 1 : 0;
        $subcategory->st_admin = session('dashboard');
        $subcategory->save();
        Logger::create([
            'log_name' => 'Subcategory',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($subcategory->toArray())]);
        return redirect()->back()->withSuccess('Updated Subcategory Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        try {
            $subcategory->delete();
            Logger::create([
                'log_name' => 'Subategory',
                'log_action' =>'Delete',
                'log_admin' => session('dashboard'),
                'log_info'=> json_encode($subcategory->toArray())]);
            return redirect()->back()->withSuccess('Deleted Subcategory Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['er'=>'Maybe has relation !']);
        }
    }
}
