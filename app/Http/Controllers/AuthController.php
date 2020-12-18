<?php

namespace App\Http\Controllers      ;

use App\City;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Hash;
use Nexmo\Laravel\Facade\Nexmo;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'phone' => 'required|string|max:17|unique:users,u_phone',
            'email' => 'required|string|email|max:255|unique:users,u_email',
            'password' => 'required|string|confirmed|max:255'
        ]);
        // dd($request->input());
        try {
            $random = mt_rand(1000, 9999);
            $user = new User;
            $user->u_first_name = $request->first_name;
            $user->u_second_name = $request->second_name;
            $user->u_phone = $request->phone;
            $user->u_email = $request->email;
            $user->password = bcrypt($request->password);
            $user->u_code = $random;
            $user->u_firebase =$request->notification ?? null;
            $user->save();
            // Nexmo::message()->send([
            //     'to'   => "+964".ltrim($request->phone, '0'),
            //     'from' => 'BizzPayment',
            //     'text' => Setting::first()->message.$random
            // ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Bad Data',
                'errors' => [
                    'sql' => 'Cannot excecute query',
                    'error' =>  $e
                ],
            ], 422);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'message' => 'Successfully created user!'
        ], 200);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone|string|email',
            'phone' => 'required_without:email|string|max:17',
            'password' => 'required|string',
        ]);
        if (!is_null($request->email)) {
            if (!Auth::attempt(['u_email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        }
        if (!is_null($request->phone)) {
            if (!Auth::attempt(['u_phone' => $request->phone, 'password' => $request->password])) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        }
        $user = $request->user();
        $user->u_firebase =$request->notification ?? null;
        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'state' => $request->user()->u_state,
            'role' => $request->user()->u_role,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user()->only([
            'u_first_name',
            'u_second_name',
            'u_phone',
            'u_email',
            'u_state',
            'u_role',
        ]));
    }
    public function company(Request $request)
    {

        $city = City::where('ct_state', 1)->get();
        $company = User::with('company')->find($request->user()->id);
        return response()->json(['company'=>$company,'city'=>$city]);
    }
    public function forgetpassword(Request $request)
    {

        $request->validate([
            'phone' => 'required|string|max:17|exists:users,u_phone',
        ]);
        $random = mt_rand(1000, 9999);
        $user = User::where('u_phone', $request->phone)->first();
        $user->u_code =  $random;
        $user->save();
        // Nexmo::message()->send([
        //     'to'   => "+964".ltrim($user->u_phone, '0'),
        //     'from' => 'BizzPayment',
        //     'text' => Setting::first()->forget.$random
        // ]);
        return response()->json([
            'message' => 'Successfully sended'
        ], 200);
    }
    public function change_password(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:17|exists:users,u_phone',
            'code' => 'required|string|max:4',
            'password' => 'required|string|confirmed|max:255'

        ]);
        $user = User::where('u_phone', $request->phone)->first();
        if ($request->code == $user->u_code) {
            $user->u_code = null;
            $user->password = bcrypt($request->password);
            $user->u_firebase =$request->notification ?? null;
            $user->save();
            if (!is_null($request->phone)) {
                if (!Auth::attempt(['u_phone' => $request->phone, 'password' => $request->password])) {
                    return response()->json([
                        'message' => 'Unauthorized'
                    ], 401);
                }
            }
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
    
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }


        return response()->json([
            'message' => 'Bad Data',
            'errors' => [
                'code' => 'Verification failed'
            ],
        ], 422);
    }
    public function verify_reset_password(Request $request)
    {
              
        $request->validate([
            'phone' => 'required|string|max:17|exists:users,u_phone',
            'code' => 'required|string|max:4',
        ], [
            'phone.in' => 'phone number not exist',
        ]);
        $user = User::where('u_phone', $request->phone)->first();
        if ($request->code == $user->u_code) {
            return response()->json([
                'message' => 'Successfully verified'
            ], 200);
        }
        return response()->json([
            'message' => 'Bad Data',
            'errors' => [
                'code' => 'Verification failed'
            ],
        ], 422);
    }

    public function verify_user(Request $request)
    {

        if ($request->user()->u_state == 1) {
            return response()->json([
                'message' => 'Bad Data',
                'errors' => [
                    'code' => 'Account verified'
                ],
            ], 422);
        }
        if ($request->user()->u_state == 2) {
            return response()->json([
                'message' => 'Bad Data',
                'errors' => [
                    'code' => 'Account Disabled'
                ],
            ], 422);
        }
        if ($request->code == $request->user()->u_code) {
            $request->user()->u_state = '1';
            $request->user()->u_code = null;
            $request->user()->u_phone_verified_at = date("Y-m-d H:i:s");
            $request->user()->save();
            return response()->json([
                'message' => 'Successfully verified'
            ], 200);
        }
        return response()->json([
            'message' => 'Bad Data',
            'errors' => [
                'code' => 'Verification failed'
            ],
        ], 422);
    }

    public function password(Request $request)
    {
        $request->validate([
            'password_old' => 'required|string|max:255',
            'password_new' => 'required|string|max:255|confirmed|different:password_old',
        ]);
        if (Hash::check($request->password_old, $request->user()->password)) {
            $user = $request->user();
            $user->password = bcrypt($request->password_new);
            $user->save();
            return response()->json([
                'message' => 'Successfully Updated password!'
            ], 200);
        }
        return response()->json([
            'message' => 'Bad Data',
            'errors' => [
                'password' => 'Wrong Old password !'
            ],
        ], 422);
    }
    public function updateInfo(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,u_email,'. $request->user()->u_email,
            'password' => 'required|string|max:255'
        ], [
            'email.not_in' => 'Your email has taken',
        ]);
        if (Hash::check($request->password, $request->user()->password)) {
            $user = $request->user();
            $user->u_first_name = $request->first_name;
            $user->u_second_name = $request->second_name;
            $user->u_email = $request->email;
            $user->save();
            return response()->json([
                'message' => 'Successfully Updated Account!'
            ], 200);
        }
        return response()->json([
            'message' => 'Bad Data',
            'errors' => [
                'password' => 'Wrong Old password !'
            ],
        ], 422);
    }
}
