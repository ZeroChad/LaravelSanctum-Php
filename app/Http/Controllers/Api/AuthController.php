<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }  
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|in:admin,user,Stocker,Client',
            'sex' => 'required|in:male,female,other',
            'birthday' => 'required|date|before:today',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()], 422);
        }

    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'role' => $request->role,
        'sex' => $request->sex,
        'birthday' => $request->birthday,
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully',
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'role' => $user->role,
            'sex' => $user->sex,
            'birthday' => $user->birthday->format('Y-m-d'),
            'age' => $user->age,
            'date_joined' => $user->created_at->format('Y-m-d H:i:s'),
        ],
        'access' => $token,
    ], 201);
}

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password'); 

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'role' => $user->role,
                'sex' => $user->sex,
                'birthday' => $user->birthday->format('Y-m-d'),
                'age' => $user->age,
                'date_joined' => $user->created_at->format('Y-m-d H:i:s'),
            ],
            'access' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
 }
