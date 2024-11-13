<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        # Menangkap inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        # Insert data ke table User
        $user = User::create($input);
        $data = [
            'message' => 'User created successfully',
        ];

        # Mengirim respon JSON
        return response()->json($data, 200);
    }

    public function login(Request $request){
        # Menangkap inputan
        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        
        # melakukan autentikasi
        if (Auth::attempt($input)){
            #membuat token
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken,
            ];

            # mengembalikan respon JSON
            return response()->json($data, 200);
        }else{
            $data = [
                'message' => 'Wrong password or email',
            ];

            # mengembalikan respon JSON
            return response()->json($data, 401);
        }

        
      
    }
}
