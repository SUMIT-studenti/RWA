<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function user(Request $request)
    {
        return Auth::user();
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
        ]);

        $user = User::create(
            [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'password' => Hash::make($request->password),
                'last_name' => $request->last_name,
            ]
        );

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }

    public function update(Request $request){
        $user = Auth::user();

        $validated = $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
        ]);
        return $user->update([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
        ]);
    }

    public function github(){
        return Socialite::driver('github')->redirect();
    }

    public function githubRedirect(){
        $user = Socialite::driver('github')->user();

        $user = User::firstOrCreate([
            'email' => $user->email
        ], [
            'email' => $user->email,
            'first_name' => $user->nickname,
            'last_name' => '',
            'password' => Hash::make(Str::random(10))
        ]);

        $token = $user->createToken('Token')->plainTextToken;

        $redirectUrl = 'http://localhost:8080/?token=' . $token;
        return redirect()->away($redirectUrl);
    }
}
