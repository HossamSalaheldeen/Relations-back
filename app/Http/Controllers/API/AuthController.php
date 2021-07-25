<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            // Authentication passed...
            $token = $request->user()->createToken('jwt')->plainTextToken;
            return response([
                'token' => $token
            ],Response::HTTP_OK);
        }

        return response([
            'error' => 'Invalid Credentials'
        ],Response::HTTP_UNAUTHORIZED);
    }

    public function user()
    {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'success'
        ],Response::HTTP_OK);
    }
}
