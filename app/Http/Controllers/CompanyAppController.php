<?php

namespace App\Http\Controllers;

use App\City;
use App\Company;
use App\Imageproductcompany;
use App\Productcompany;
use App\RedeemCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyAppController extends Controller
{
    public function city()
    {
        $city = City::where('ct_state', 1)->get();
        return response()->json([
            'city' => $city
        ], 200);
    }
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_account' => 'required|string|max:17|unique:users,u_phone',
            'email' => 'required|string|email|max:255|unique:users,u_email',
            'password' => 'required|string|confirmed|max:255|min:6',
            'address' => 'required|string|max:1250',
            'city' => 'required|exists:cities,id',
            'information' => 'max:1250',

        ]);
        try {
            $company = new Company;
            $user = new User;
            $user->u_first_name = 'Company';
            $user->u_second_name = $request->company_name;
            $user->u_phone = $request->phone_account;
            $user->u_email = $request->email;
            $user->u_role = "COMPANY";
            $user->u_city = $request->city;
            $user->password = bcrypt($request->password);
            $user->u_firebase = $request->notification ?? null;
            $user->save();

            $company->co_name = $request->company_name;
            $company->co_phone = $request->phone_account;
            $company->co_address = $request->address;
            $company->co_info = $request->information;
            $company->co_user =  $user->id;
            $company->co_admin = $user->id;
            $company->save();
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
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_account' => 'required|string|max:17|unique:users,u_phone,' . $request->user()->id,
            'email' => 'required|string|email|max:255||unique:users,u_email,' . $request->user()->id,
            'address' => 'required|string|max:1250',
            'city' => 'required|exists:cities,id',
            'information' => 'max:1250',
        ]);
        try {
            $user = User::find($request->user()->id);
            $company = Company::where('co_user', $user->id)->first();
            $user->u_second_name = $request->company_name;
            $user->u_phone = $request->phone_account;
            $user->u_email = $request->email;
            $user->u_city = $request->city;
            $user->save();
            $company->co_name = $request->company_name;
            $company->co_phone = $request->phone_account;
            $company->co_address = $request->address;
            $company->co_info = $request->information;
            $company->co_user =  $user->id;
            $company->co_admin = $user->id;
            $company->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Bad Data',
                'errors' => [
                    'sql' => 'Cannot excecute query',
                    'error' =>  $e
                ],
            ], 422);
        }
        return response()->json([
            'message' => 'Successfully created user!'
        ], 200);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',

            // 'image' => 'required|base64image:jpeg,png,jpg,gif|base64max:8192',
        ]);
        // $extention =  explode('/', mime_content_type($request->image))[1];
        $user = User::with('company')->find($request->user()->id);
        $company = Company::find($user->company->id);
        $path = $company->co_image;
        $company->co_image = isset($request->image)  ? $request->image->store('uploads', 'public') : null;
        // $company->co_image = saveImageBase64Company($request->image);
        $company->save();
        Storage::delete('public/' . $path);
        return response()->json([
            'message' => 'Successfully Uploaded!',
        ], 200);
    }
    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'disc' => 'required|string|max:1250',
            'price' => 'required|numeric|gte:0',
        ]);
        $product = new Productcompany;
        $product->pc_name = $request->name;
        $product->pc_disc = $request->disc;
        $product->pc_price = $request->price;
        $product->pc_company = $request->user()->id;
        $product->save();
        return response()->json([
            'message' => 'Successfully Added Product!',
            'id' => $product->id,
        ], 200);
    }
    public function updateProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:productcompanies,id',
            'name' => 'required|string|max:255',
            'disc' => 'required|string|max:1250',
            'price' => 'required|numeric|gte:0',
        ]);
        $product = Productcompany::find($request->id);
        $product->pc_name = $request->name;
        $product->pc_disc = $request->disc;
        $product->pc_price = $request->price;
        $product->save();
        return response()->json([
            'message' => 'Successfully Updated Product!',
        ], 200);
    }
    public function deleteProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:productcompanies,id',
        ]);
        $product = Productcompany::find($request->id);
        $image = Imageproductcompany::where('ipc_product', $product->id)->delete();
        $product->delete();
        return response()->json([
            'message' => 'Successfully Deleted Product!',
        ], 200);
    }
    public function addImage(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:productcompanies,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);
        $pro = Productcompany::find($request->id);
        if ($pro->pc_company != $request->user()->id) {
            return response()->json([
                'message' => 'Permission Denied!',
            ], 422);
        }
        $product = new Imageproductcompany;
        $product->ipc_image = $request->image->store('uploads', 'public');
        $product->ipc_product = $request->id;
        $product->save();
        return response()->json([
            'message' => 'Successfully Added Image!',
        ], 200);
    }
    public function getProduct(Request $request)
    {
        $product = Productcompany::with(['images'])->where('pc_company', $request->user()->id)->get();
        return response()->json([
            'product' => $product
        ], 200);
    }
    public function getRedeem(Request $request)
    {
        $redeem = RedeemCode::with('user')->where('rc_company', auth()->user()->id)->where('rc_state', 1)->orderBy('rc_state')->limit(30)->get();
        return response()->json([
            'redeem' => $redeem
        ], 200);
    }
    public function getRedeemSearch(Request $request)
    {
        $redeem = RedeemCode::with('user')->where('rc_company', auth()->user()->id)->where('rc_state', 1)->whereDate('updated_at', $request->date)->orderBy('rc_state')->limit(30)->get();
        return response()->json([
            'redeem' => $redeem
        ], 200);
    }
    public function scanRedeem(Request $request)
    {
        $redeem = RedeemCode::with('user')->where('rc_company', auth()->user()->id)->where('rc_state', 0)->where('rc_code', $request->code)->first();
        if (empty($redeem)) {
            return response()->json([
                'error' => 'Code Used or Wrong'
            ], 400);
        } else {
            $redeem->rc_state = 1;
            $redeem->save();
            return response()->json([
                'redeem' => $redeem
            ], 200);
        }
    }
    public function search(Request $request)
    {
        $redeem = RedeemCode::with('user')->whereHas('user' , function ($sql) use ($request) {
            $sql->where(function ($query)use ($request){
                $query->where('u_first_name', 'like', '%' . $request->search . '%');
                $query->orWhere('u_second_name', 'like', '%' . $request->search . '%');
                $query->orWhere('u_email', 'like', '%' . $request->search . '%');
                $query->orWhere('u_phone', 'like', '%' . $request->search . '%');
            });
        })->where('rc_company', auth()->user()->id)->where('rc_state', 1)->get();
        return response()->json([
            'redeem' => $redeem
        ], 200);
    }
}
