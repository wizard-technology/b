<?php

namespace App\Http\Controllers;

use App\Logger;
use App\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SocialMedia::with('admin')->orderBy('sm_state')->orderBy('created_at')->get();
        return view('pages.social.index', ['data' => $data]);
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
            'icon' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);
        $social = new SocialMedia;
        $social->sm_icon = $request->icon;
        $social->sm_link = $request->link;
        $social->sm_state =  $request->state == 'on' ? 1 : 0;
        $social->sm_admin = session('dashboard');
        $social->save();
        Logger::create([
            'log_name' => 'Social Media',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($social->toArray())
        ]);
        return redirect()->back()->withSuccess('Added Soical Media Successfully !');
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
        $social = SocialMedia::findOrFail($id);
        $social->sm_state = !$social->sm_state;
        $social->save();
        Logger::create([
            'log_name' => 'Social Media',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($social->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Social Media Successfully !');
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
        $request->validate([
            'icon' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);
        $social = SocialMedia::findOrFail($id);
        $social->sm_icon = $request->icon;
        $social->sm_link = $request->link;
        $social->sm_state =  $request->state == 'on' ? 1 : 0;
        $social->sm_admin = session('dashboard');
        $social->save();
        Logger::create([
            'log_name' => 'Social Media',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($social->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Soical Media Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social = SocialMedia::findOrFail($id);
        $social->delete();
        Logger::create([
            'log_name' => 'Social Media',
            'log_action' => 'Delete',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($social->toArray())
        ]);
        return redirect()->back()->withSuccess('Deleted Social Media Successfully !');

    }
}
