<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('u_role','ADMIN')->findOrFail($id);
        return view('pages.auth.profile', ['data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user =  User::findOrFail(session('dashboard'));
        if($id == 1){
            $request->validate([
                'first_name' => 'required|string|max:255',
                'second_name' => 'required|string|max:255',
            ]);
            $user->u_first_name  = $request->first_name;
            $user->u_second_name = $request->second_name; 
            $user->save(); 
        }else{
            $request->validate([
                'old_password' => 'required|string|max:255',
                'password' => 'required|string|confirmed|max:255|min:6|different:old_password',
            ]);
            $user->password = bcrypt($request->password);
            $user->save(); 
        }
        return redirect()->back()->withSuccess('Updated Profile Successfully !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
