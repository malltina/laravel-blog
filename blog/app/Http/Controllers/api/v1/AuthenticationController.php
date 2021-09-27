<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        $response = [
            'user'=>$user,
            'token' => $user->createToken('tokens')->plainTextToken
        ];

        return response($response, Response::HTTP_CREATED);
    }
    
    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email',$attr['email'])->first();

        $response = [
            'user'=>$user,
            'token' => $user->createToken('tokens')->plainTextToken
        ];

        return response($response, Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $response = [
            'message' => 'loged out'
        ];

        return response($response);
    }

}