<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function login(Request $loginRequest)
    {
        $data = $loginRequest->all();

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $user->details;

            // Generate Token
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->jsonRes()
                        ->data(["profile" => $user])
                        ->message('Login Success.')
                        ->header(["X-ACCESS-TOKEN, $token"])
                        ->success();
        } else {
            return $this->jsonRes()
                        ->message('Invalid username/password.')
                        ->error();
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('sanctum')->user())
            Auth::guard('sanctum')->user()->currentAccessToken()->delete();

        return $this->jsonRes()
                    ->message('Logout Success.')
                    ->success();
    }
}
