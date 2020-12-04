<?php

namespace App\Http\Controllers;

use App\Help;
use App\Logger;
use App\User;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $help = Help::with('user')->where('h_from', 0)->orderBy('h_state')->orderBy('id', 'DESC')->get();
        return view('pages.support.index', [
            'data' => $help
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
            'report' => 'required|string|max:1000',
            'user' => 'required|exists:users,id',
        ]);
        $help = new Help;
        $help->h_info = $request->report;
        $help->h_user = $request->user;
        $help->h_from = session('dashboard');
        $help->h_state = 0;
        $help->save();
        Logger::create([
            'log_name' => 'Support',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($help->toArray())
        ]);
        return redirect()->back()->withSuccess('Sent report Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $update = Help::where('h_user', $id)->where('h_state', 0)->get();
        if (count($update) > 0) {
            Logger::create([
                'log_name' => 'Support',
                'log_action' => 'Updated',
                'log_admin' => session('dashboard'),
                'log_info' => json_encode($update->toArray())
            ]);
        }
        Help::where('h_user', $id)->where('h_state', 0)->where('h_from', 0)->update(['h_state' => 1]);
        $help = Help::with('user')->where('h_user',  $id)->orderBy('h_state')->orderBy('id', 'DESC')->limit(30)->get();
        return view('pages.support.show', [
            'data' => $help,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function edit(Help $help)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Help $help)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function destroy(Help $help)
    {
        //
    }
}
