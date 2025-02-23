<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated =$request->validate([
            'name' => 'required|string|max:255',
            'email' =>'required|string|email|unique:users',
            'phone' =>'required|string|max:255',
            'password' => 'required|string|min:6',
            'role' =>'required|in:patient,doctor,admin',
            'gender' =>'required|in:male,female',
        ]);

        $user = User::create([
           'name'=> $validated['name'],
           'email'=> $validated['email'],
           'phone'=> $validated['phone'],
           'password'=> Hash::make($validated['password']),
           'role'=> $validated['role'],
            'gender'=> $validated['gender'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=>"register success",
            'token'=>$token,
            'user'=>$user
        ],);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
           'email' =>'required|string|email',
           'password' =>'required|string|min:6',
        ]);

        $user = User::where('email',$validated['email'])->first();

        if(!$user || !Hash::check($validated['password'],$user->password)){
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=>"login success",
            'token'=>$token,
            'user'=>$user
        ]);
    }



}
