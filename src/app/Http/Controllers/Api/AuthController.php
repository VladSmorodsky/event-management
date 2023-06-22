<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

//        if (!$user) {
//            throw ValidationException::withMessages([
//                'email' => 'Provided creds are incorrect'
//            ]);
//        }
//
//        if (!Hash::check($request->password, $user->password)) {
//            throw ValidationException::withMessages([
//                'message' => 'Provided creds are incorrect'
//            ]);
//        }

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                'message' => 'Provided creds are incorrect'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
