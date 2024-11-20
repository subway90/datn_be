<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    // Chuyển hướng đến Google
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback(Request $request)
    {
        $code = $request->input('code');

        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt('random_password')
            ]);
        }

        Auth::login($user);

        $token = $user->createToken('ID USER: ' . $user->id)->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user->name, 'email' => $user->email, 'google_id' => $user->id, 'avatar' => $user->avatar], 200);
    }
}
