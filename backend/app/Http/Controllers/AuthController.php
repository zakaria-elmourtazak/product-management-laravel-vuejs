<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        // $fields = $request->validate([
        //     'email' => 'required|string',
        //     'password' => 'required|string'
        // ]);

        // // Check email
        // $user = User::where('email', $fields['email'])->first();

        // // Check password
        // if(!$user || !Hash::check($fields['password'], $user->password)) {
        //     return response([
        //         'message' => 'Bad creds'
        //     ], 401);
        // }
         if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

      
        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        return response([
            'message' => $token
        ])->withCookie($cookie);

        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        // return response($response, 201);
    }
    
    public function user()
    {
        return Auth::user();
    }
    
    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }
    // public function logout() {
    //     auth()->user()->tokens()->delete();

    //     return [
    //         'message' => 'Logged out'
    //     ];
    // }
}
