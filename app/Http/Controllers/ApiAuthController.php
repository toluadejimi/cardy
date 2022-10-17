<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;



class ApiAuthController extends Controller
{


    public $successStatus = true;
    public $failedStatus = false;







    public function register(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'f_name' => 'required|string|max:255',
        'l_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'phone' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'pin' => 'required|string|max:255',
        'password' => 'required|string|confirmed|max:255',
    ]);

    // Return errors if validation error occur.
    if ($validator->fails()) {
        $errors = $validator->errors();
        return response()->json([
            'error' => $errors
        ], 400);
    }

    // Check if validation pass then create user and auth token. Return the auth token
    if ($validator->passes()) {
        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'gender'=>$request->gender,
            'name' => $request->name,
            'type' => 2,
            'password' => Hash::make($request->password),
            'pin' => Hash::make($request->pin)



        ]);


        //$token = $user->createToken('auth_token')->plainTextToken;

        $token = $user->createToken('API Token')->accessToken;

       // $token = auth()->user()->createToken('API Token')->accessToken;


        return response()->json([
            'status' => $this->successStatus,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',

        ],200);
    } else{
        return response()->json([
            'status' => $this->failedStatus,
            'message'    => 'Error',
        ], 401);
    }
}






public function login(Request $request)
{
    if (!Auth::attempt($request->only('phone', 'password'))) {
        return response()->json([
            'message' => 'Invalid login details'
        ], 401);
    }
    $user = User::where('phone', $request['phone'])->firstOrFail();
    $token = $user->createToken('auth_token')->accessToken;

    return response()->json([
        'access_token' => $token,
    ]);

}


public function user(Request $request)

{

    dd('hello');
    $user = $request->user();




    // return response()->json([
    //     'status' => $this->successStatus,
    //     'user' => $user,
    //     //'access_token' => $token,
    //     'token_type' => 'Bearer',

    // ],200);


}

}

































