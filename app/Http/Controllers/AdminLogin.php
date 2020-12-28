<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLogin extends Controller
{
    function login()
    {
        $user = User::where('u_role', 'ADMIN')->get();
        if (count($user) == 0) {
            return view('pages.auth.signup');
        } else {
            if (session()->exists('dashboard')) {
                return  redirect()->route('dashboard.index');
            }
            return view('pages.auth.login');
        }
    }
    function check(Request $request)
    {
        $user = User::where('u_role', 'ADMIN')->get();
        if (count($user)  == 0) {
            return view('pages.auth.signup');
        } else {
            $validated = $request->validate([
                'email' => 'required|string|email|max:255|exists:users,u_email',
                'password' => 'required|string|max:255',
            ]);
            $data = User::where('u_email', $request->email)->first();
            if (Hash::check($request->password, $data->password)) {
                session()->put('dashboard', $data->id);
                return redirect()->route('dashboard.index');
            } else {
                return redirect()->back()->withInput($request->input())->withErrors(['password' => 'Incorrect password']);
            }
        }
    }
    function show()
    {
        // return view('settings.pages.user');

    }
    function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required_without:phone|string|email',
            'phone' => 'required_without:email|string|max:17',
            'password' => 'required|string',
        ]);
        $data = User::findOrFail(session()->get('user'));
        if (isset($data)) {
            if (Hash::check($request->password, $data->password)) {
                $data->username = $request->username;
                $data->save();
                session()->put('user', $data->id);
                return  back()->withSuccess('Username updated');
            } else {
                return redirect()->back()->withErrors('Incorrect password');
            }
        }
    }
    function password(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|max:255|min:6',
            'new_password' => 'required|max:255|min:6|different:password',
            'confirm_password' => 'same:new_password',
        ]);
        $data = User::findOrFail(session()->get('user'));
        if (isset($data)) {
            if (Hash::check($request->password, $data->password)) {
                $data->password = Hash::make($request->new_password);
                $data->save();
                session()->put('user', $data->id);
                return  back()->withSuccess('Password updated');
            } else {
                return redirect()->back()->withErrors('Incorrect password');
            }
        }
    }

    function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'phone' => 'required|string|max:17|unique:users,u_phone',
            'email' => 'required|string|email|max:255|unique:users,u_email',
            'password' => 'required|string|confirmed|max:255|min:6'
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
        $admin->a_admin = $user->id;
        $admin->a_user = $user->id;
        $admin->a_access = json_encode([
            'index',
            'company',
            'type',
            'product',
            'card',
            'support',
            'employee',
            'city',
            'user',
            'tag',
            'order',
            'setting',
            'profile',
            'bizzcoin',
            'subcategory',
            'grouped',
            'social',
        ]);
        $admin->save();
        session()->put('dashboard', $user->id);
        DB::table('articles')->insert([[
            'id' => 1,
            'ar_article' => json_encode('Write Some Things Here'),
            'ar_article_ku' => json_encode('لێرە شتێک بنووسە'),
            'ar_article_ar' => json_encode('اكتب بعض الأشياء هنا'),
            'ar_article_pr' => json_encode('برخی موارد را در اینجا بنویسید'),
            'ar_article_kr' => json_encode('Li vir Hin Tiştan Binivîse'),
            'ar_admin' => session('dashboard'),
            'ar_type' => 'term',
        ], [
            'id' => 2,
            'ar_article' => json_encode('Write Some Things Here'),
            'ar_article_ku' => json_encode('لێرە شتێک بنووسە'),
            'ar_article_ar' => json_encode('اكتب بعض الأشياء هنا'),
            'ar_article_pr' => json_encode('برخی موارد را در اینجا بنویسید'),
            'ar_article_kr' => json_encode('Li vir Hin Tiştan Binivîse'),
            'ar_admin' => session('dashboard'),
            'ar_type' => 'privacy',
        ],[
            'id' => 3,
            'ar_article' => json_encode('Write Some Things Here'),
            'ar_article_ku' => json_encode('لێرە شتێک بنووسە'),
            'ar_article_ar' => json_encode('اكتب بعض الأشياء هنا'),
            'ar_article_pr' => json_encode('برخی موارد را در اینجا بنویسید'),
            'ar_article_kr' => json_encode('Li vir Hin Tiştan Binivîse'),
            'ar_admin' => session('dashboard'),
            'ar_type' => 'title_home',
        ],[
            'id' => 4,
            'ar_article' => json_encode('Write Some Things Here'),
            'ar_article_ku' => json_encode('لێرە شتێک بنووسە'),
            'ar_article_ar' => json_encode('اكتب بعض الأشياء هنا'),
            'ar_article_pr' => json_encode('برخی موارد را در اینجا بنویسید'),
            'ar_article_kr' => json_encode('Li vir Hin Tiştan Binivîse'),
            'ar_admin' => session('dashboard'),
            'ar_type' => 'disc_home',
        ]]);
        return redirect()->route('dashboard.index');
    }
    function logout()
    {
        if (session()->exists('dashboard')) {
            session()->forget('dashboard');
            session()->save();
            return redirect()->route('dashboard.login');
        }
    }
    function notFound()
    {
        $user = User::findOrFail(session('dashboard'));
        return view('pages.auth.not',['dashboard_admin'=> $user]);
    }
}
