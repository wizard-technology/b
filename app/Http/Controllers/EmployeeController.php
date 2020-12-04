<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Logger;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with(['admin', 'logger'])->where('id', '<>', session('dashboard'))->where('u_role', 'ADMIN')->get();

        return view('pages.employee.index', ['data' => $data]);
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
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'phone' => 'required|string|max:17|unique:users,u_phone',
            'email' => 'required|string|email|max:255|unique:users,u_email',
            'password' => 'required|string|confirmed|max:255|min:6',
            'access' => 'array',

        ]);
        $user = new User;
        $user->u_first_name = $request->first_name;
        $user->u_second_name = $request->second_name;
        $user->u_phone = $request->phone;
        $user->u_email = $request->email;
        $user->password = bcrypt($request->password);
        $user->u_phone_verified_at = date("Y-m-d H:i:s");
        $user->u_role = 'ADMIN';
        $user->u_state = 1;
        $user->save();
        $admin = new Admin;
        $admin->a_admin = session('dashboard');
        $admin->a_user = $user->id;
        $admin->a_access = json_encode($request->access);
        $admin->save();
        Logger::create([
            'log_name' => 'Admin',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($user->toArray())
        ]);
        return redirect()->back()->withSuccess('Added Admin Successfully !');
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
        $user =  User::findOrFail($id);
        if ($user->u_state == 0 || $user->u_state == 2) {
            $user->u_state = 1;
            $user->u_phone_verified_at = date("Y-m-d H:i:s");
        } else {
            $user->u_state = 2;
        }
        $user->save();
        Logger::create([
            'log_name' => 'Admin',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($user->toArray())
        ]);

        return redirect()->back()->withSuccess('Updated Admin Successfully !');
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
        $user =  User::findOrFail($id);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,u_email,' . $user->id,
            'phone' => 'required|string|max:17|unique:users,u_phone,' . $user->id,
            'password' => 'max:255',
            'password_confirmation' => 'max:255|same:password',
            'code' => 'max:4',
            'state' => 'sometimes|in:0,1,2',
            'access' => 'array',
        ]);
        $user->u_first_name = $request->first_name;
        $user->u_second_name = $request->second_name;
        $user->u_email = $request->email;
        $user->u_phone = $request->phone;
        $user->u_code = $request->code;
        if ($user->u_state != 1 && $request->state == 1) {
            $user->u_phone_verified_at = date("Y-m-d H:i:s");
        }
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->u_state = $request->state;
        $user->save();
        $admin = Admin::findOrFail($user->id);
        $admin->a_access = json_encode($request->access);
        $admin->save();

        Logger::create([
            'log_name' => 'Admin',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($user->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Admin Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->back()->withErrors('You Can not Delete Admin !');
    }
}
