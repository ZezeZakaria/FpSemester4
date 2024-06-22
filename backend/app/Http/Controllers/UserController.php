<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate user input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email|max:255', // Added unique validation
                'password' => 'required|string|min:8',
            ]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Return successful registration response
            return response()->json($user, 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            // Handle other unexpected errors (e.g., database errors)
            report($e); // Log the error for debugging

            return response()->json([
                'message' => 'Registration failed. Please try again later.',
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            /**
             * @var \App\Models\User
             */
            $user = auth()->user();

            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'token' => $token,
                'name' => auth()->user()->name,
            ]);
        } catch (\Throwable $e) {
            // Handle unexpected errors (e.g., database issues)
            report($e); // Log the error for debugging
            return response()->json([
                'message' => 'Login failed. Please try again later.',
            ], 500);
        }
    }


    public function googleLogin(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $googleUser = Http::get('https://www.googleapis.com/oauth2/v3/tokeninfo', [
            'id_token' => $request->token,
        ]);

        if ($googleUser->failed()) {
            return response()->json(['message' => 'Invalid Google token'], 401);
        }

        $googleUser = $googleUser->json();

        // Find or create the user
        $user = User::firstOrCreate(
            ['email' => $googleUser['email']],
            ['name' => $googleUser['name'], 'password' => Hash::make(uniqid())]
        );

        $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json(['token' => $token, 'name' => $user->name]);
    }
}
