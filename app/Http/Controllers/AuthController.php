<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        // $response = response([
        //     'user' => $user, 
        //     'token' => $token], 201);

        return response()->json([
            'user' => $user, 
            'token' => $token,
            'message' => 'Successfully created user!'
        ], 201);

        // $token = $user->createToken('authToken')->accessToken;
        // $user = new User([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        // $user->save();

        // return response()->json([
        //     'message' => 'Successfully created user!'
        // ], 201);
    }
    
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

       // check email
       $user = User::where('email', $fields['email'])->first();

       if(!$user || !Hash::check($fields['password'], $user->password)){
           return response()->json([
               'message' => 'Bad Credentails used, please try with correct username or email and password!'
           ], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user, 
            'token' => $token,
            'message' => 'Login Successfully !'
        ], 200);
    }


    public function logout(){

        // by github copilot code
        auth()->user()->tokens->each(function($token, $key){
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
