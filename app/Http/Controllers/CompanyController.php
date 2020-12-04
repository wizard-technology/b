<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\City;
use App\Logger;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = City::where('ct_state', 1)->get();
        $data = User::with(['company.admin', 'city'])->where('u_role', 'COMPANY')->orderBy('u_state')->get();
        return view('pages.company.index', ['data' => $data, 'city' => $city]);
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
            'company_name' => 'required|string|max:255',
            'phone_account' => 'required|string|max:17|unique:users,u_phone',
            'phone_company' => 'required|string|max:17',
            'email' => 'required|string|email|max:255|unique:users,u_email',
            'password' => 'required|string|confirmed|max:255|min:6',
            'address' => 'required|string|max:1250',
            'city' => 'required|exists:cities,id',
            'information' => 'max:1250',
            'imgs' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:0,1,2',
        ]);
        $user = new User;
        $user->u_first_name = $request->first_name;
        $user->u_second_name = $request->second_name;
        $user->u_phone = $request->phone_account;
        $user->u_email = $request->email;
        $user->u_city = $request->city;
        $user->password = bcrypt($request->password);
        $user->u_phone_verified_at = date("Y-m-d H:i:s");
        $user->u_role = 'COMPANY';
        $user->u_state = $request->state;
        $user->save();
        $company = new Company;
        $company->co_name = $request->company_name;
        $company->co_phone = $request->phone_company;
        $company->co_address = $request->address;
        $company->co_info = $request->information;
        $company->co_image = isset($request->imgs)  ? $request->imgs->store('uploads', 'public'): null;
        $company->co_user = $user->id;
        $company->co_admin = session('dashboard');
        $company->save();

        Logger::create([
            'log_name' => 'Company',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($user->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Create Company Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
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

        return redirect()->back()->withSuccess('Updated Company Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::with('company')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone_account' => 'required|string|max:17|unique:users,u_phone,'. $user->id,
            'phone_company' => 'required|string|max:17',
            'email' => 'required|string|email|max:255|unique:users,u_email,'. $user->id,
            'password' => 'max:255',
            'password_confirmation' => 'max:255|same:password',
            'address' => 'required|string|max:1250',
            'city' => 'required|exists:cities,id',
            'information' => 'max:1250',
            'imgs' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:0,1,2',
        ]);
        $user->u_first_name = $request->first_name;
        $user->u_second_name = $request->second_name;
        $user->u_phone = $request->phone_account;
        $user->u_email = $request->email;
        $user->u_city = $request->city;
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->u_phone_verified_at = date("Y-m-d H:i:s");
        $user->u_role = 'COMPANY';
        $user->u_state = $request->state;
        $user->save();
        $user->company->co_name = $request->company_name;
        $user->company->co_phone = $request->phone_company;
        $user->company->co_address = $request->address;
        $user->company->co_info = $request->information;
        $path = $request->imgs == null ? null : $user->company->co_image;
        $user->company->co_image =isset($request->imgs)  ? $request->imgs->store('uploads', 'public'): $user->company->co_image;
        $user->company->co_admin = session('dashboard');
        $user->company->save();
        if (isset($path)) {
            Storage::delete('public/' . $path);
        }
        Logger::create([
            'log_name' => 'Company',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($user->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Updated Company Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::with('company')->findOrFail($id);
        try {
            Storage::delete('public/' . $user->company->co_image);
            $user->company->delete();
            $user->delete();
            Logger::create([
                'log_name' => 'Company',
                'log_action' => 'Delete',
                'log_admin' => session('dashboard'),
                'log_info' => json_encode($user->toArray())
            ]);
            return redirect()->back()->withSuccess('Deleted Company Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Maybe has relation !');
        }
    }
}
