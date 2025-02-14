<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Welcome to the authentication page'
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            // Hash the password before saving
            $data['password'] = Hash::make($data['password']);

            // Create user
            $user = User::create($data);

            // Generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => 'Failed to create user',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid email or password',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
