<?php

namespace App\Http\Controllers;

use App\Logger;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Type::with('admin')->orderBy('t_state')->orderBy('created_at')->get();
        return view('pages.category.index',['data'=>$data]);
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
        // dd($request->input());
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'imgs' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
        ]);
        $type = new Type;
        $type->t_name = $request->name;
        $type->t_name_ku = $request->name_kurdish;
        $type->t_name_ar = $request->name_arabic;
        $type->t_name_pr = $request->name_persian;
        $type->t_name_kr = $request->name_kurmanji;
        $type->t_image = $request->imgs->store('uploads', 'public');
        $type->t_state =  $request->state == 'on' ? 1 : 0;
        $type->t_admin = session('dashboard');
        $type->save();
        Logger::create([
            'log_name' => 'Category',
            'log_action' =>'Create',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($type->toArray())]);
        return redirect()->back()->withSuccess('Added Category Successfully !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        if (is_null($type)) return response()->json([
            'message' => 'type not found',
            'errors' => [
                'type' => 'Wrong id'
            ]
        ], 404);
        return response()->json([
            'type' => $type
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        $type->t_state = !$type->t_state;
        $type->save();
        Logger::create([
            'log_name' => 'Category',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($type->toArray())]);
        return redirect()->back()->withSuccess('Updated Category Successfully !');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'imgs' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
        ]);
        
        $type->t_name = $request->name;
        $type->t_name_ku = $request->name_kurdish;
        $type->t_name_ar = $request->name_arabic;
        $type->t_name_pr = $request->name_persian;
        $type->t_name_kr = $request->name_kurmanji;
        $type->t_image = isset($request->imgs)  ? $request->imgs->store('uploads', 'public')     : $type->t_image;
        $type->t_state =   $request->state == 'on' ? 1 : 0;
        $type->t_admin = session('dashboard');
        $type->save();
        Logger::create([
            'log_name' => 'Category',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=> json_encode($type->toArray())]);
        return redirect()->back()->withSuccess('Updated Category Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        try {
            $type->delete();
            Logger::create([
                'log_name' => 'Category',
                'log_action' =>'Delete',
                'log_admin' => session('dashboard'),
                'log_info'=> json_encode($type->toArray())]);
            return redirect()->back()->withSuccess('Deleted Category Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['er'=>'Maybe has relation !']);
        }
    }
}
