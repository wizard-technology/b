<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Logger;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  User::where('u_role', 'USER')->get();
        return view('pages.user.index', ['data' => $data]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['cart.product'])->findOrfail($id);
        return view('pages.user.show', ['data' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user =  User::findOrFail($id);
        if ($user->u_state == 0 || $user->u_state == 2) {
            $user->u_state = 1;
            $user->u_phone_verified_at = date("Y-m-d H:i:s");
        } else {
            $user->u_state = 2;
        }
        $user->save();
        Logger::create([
            'log_name' => 'User',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=>json_encode($user->toArray())]);

        return redirect()->back()->withSuccess('Updated User Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,u_email,' . $user->id,
            'phone' => 'required|string|max:17|unique:users,u_phone,' . $user->id,
            'code' => 'max:4',
            'state' => 'sometimes|in:0,1,2',

        ]);
        $user->u_first_name = $request->first_name;
        $user->u_second_name = $request->second_name;
        $user->u_email = $request->email;
        $user->u_phone = $request->phone;
        $user->u_code = $request->code;
        if ($user->u_state != 1 && $request->state == 1) {
            $user->u_phone_verified_at = date("Y-m-d H:i:s");
        }
        $user->u_state =   $request->state;
        $user->save();
        Logger::create([
            'log_name' => 'User',
            'log_action' =>'Update',
            'log_admin' => session('dashboard'),
            'log_info'=>json_encode($user->toArray())]);
        return redirect()->back()->withSuccess('Updated User Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        return redirect()->back()->withErrors('You Can not Delete User !');
    }
}
