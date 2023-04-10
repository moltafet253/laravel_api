<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'c_password' => 'required|same:password',
        ]);

        if (!$validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token=$user->createToken('myApp')->accessToken;
        return $this->successResponse([
            'user'=>$user,
            'token'=>$token
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user=User::where('email',$request->email)->first();
        if (!$user||!Hash::check($request->password , $user->password)){
            return $this->errorResponse('user or password is wrong',401);
        }

        $token=$user->createToken('myApp')->accessToken;
        return $this->successResponse([
            'user'=>$user,
            'token'=>$token
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse('logged out',200);
    }
}
