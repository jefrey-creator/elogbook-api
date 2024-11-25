<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $data = $request->validate([
            'email' => 'required|string|unique:users,email|max:100',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
        ]);

        $token = $user->createToken('university-mis')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            "message" => "You have successfully registered.",
            "data" => $response
        ], 200);
    }

    public function login(Request $request){
        
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
                "message" => "Incorrect email or password."
            ], 401);
        }

        $token = $user->createToken('sanctum-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            "message" => "You have successfully logged in.",
            "data" => $response
        ], 200);
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "You have successfully logged out.",
        ], 200);

    }
}
