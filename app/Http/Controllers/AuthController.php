<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUser;
use App\Models\User;
use App\Traits\HTTPResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HTTPResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        return $this->sucess([
            'user' => $user,
            'token' => $user->createToken('Api Token of (^_^)' . $user->name)->plainTextToken,
        ]);

    }
    public function register(StoreUser $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->sucess([
            'user' => $user,
            'token' => $user->createToken('Api Token of (^_^)' . $user->name)->plainTextToken,
        ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have succesfully been logged out and your token has been removed',
        ]);
    }
}
