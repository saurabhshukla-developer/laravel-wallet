<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @method register
     * Register New User
     * @param $request
     * @return response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|regex:/^[a-zA-Z\s.-]+$/|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Bad or invalid request', 'errors' => $validator->errors()], 400);
            }

            User::create([
                'name' => trim($request->name),
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Throwable $th) {
            Log::error('An error occurred while registering user: ' . $th->getMessage());
            return response()->json(['message' => 'An error occurred while registering user'], 500);
        }
    }


    /**
     * @method login
     * Login User
     * @param $request
     * @return response
     */
    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Bad or invalid request', 'errors' => $validator->errors()], 400);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = Auth::user()->createToken('authToken')->plainTextToken;

                return response()->json(['token' => $token], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Throwable $th) {
            Log::error('An error occurred while logging in: ' . $th->getMessage());
            return response()->json(['message' => 'An error occurred while logging in'], 500);
        }
    }
}
