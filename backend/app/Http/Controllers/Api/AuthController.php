<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate user input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email|max:255', // Added unique validation
                'password' => 'required|string|min:8',
                'address' => 'required'
            ]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'address' => $request->address
            ]);

            // Return successful registration response
            return response()->json(
                ['data' => ['user' => $user, 'token' => $user->createToken('AuthToken')->plainTextToken]],
                201
            );
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
                'user' => $user,
            ]);
        } catch (\Throwable $e) {
            // Handle unexpected errors (e.g., database issues)
            report($e); // Log the error for debugging
            return response()->json([
                'message' => 'Login failed. Please try again later.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout']);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email']);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation errors.', 'errors' => $validator->errors()], 400);
        }

        $curr_user = User::where('id', "!=", $request->user()->id)->where(['email' => $request->email])->first();

        if ($curr_user) {
            return response()->json(['message' => 'Email telah digunakan'], 400);
        }

        $user = User::where(['id' => $request->user()->id])->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['data' => $user, 'message' => "Berhasil mengupdate data"]);
    }
}
