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
    public function __contruct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }  
    
    public function register(Request $request)
    {
        validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|in:admin,user,Stocker,Client',
            'sex' => 'required|in:male,female,other',
            'birthday' => 'required|date|before:today',
        ]);
    }
}
