<?php

namespace App\Domains\User\Http\Controllers\Api;

use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request) {
        $loginData = $request->validate([
          'email' => 'email|required',
          'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
          return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

      public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
          'message' => 'Successfully logged out'
        ]);
      }

      public function user(Request $request) {
        return response()->json($request->user());
      }
}
