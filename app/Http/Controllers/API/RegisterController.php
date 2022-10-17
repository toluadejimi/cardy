<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'f_name' => 'required|string|max:255',
        'l_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'phone' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'pin' => 'required|string|max:255',
        'password' => 'required|string|confirmed|max:255',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['type'] = 2;
        $input['password'] = bcrypt($input['password']);
        $input['pin'] = bcrypt($input['pin']);
        $user = User::create($input);
        $status['token'] =  $user->createToken('MyApp')->accessToken;

        return $this->sendResponse($status, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */





    public function login(Request $request)
    {
        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])){
            $user = Auth::user();
            
            $status['token'] =  $user->createToken('MyApp')->accessToken;

            $user_info = User::where('id', Auth::id())->first();

            $status['user'] =  $user_info;

            return $this->sendResponse($status, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
