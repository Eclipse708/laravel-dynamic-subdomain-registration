<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $fullDomain = request()->getHost();
            $subDomain = explode('.', $fullDomain)[0];
            $credentials = $request->validated();

            if (Auth::attempt($credentials)) {
                $user_id = auth()->user()->id;
                $user = User::where('id', $user_id)->first();
                $userSubdomain = $user->account->domain;

                if ($subDomain !== $userSubdomain) {
                    Auth::logout();

                    return back()->withErrors([
                        'email' => 'Invalid login credentials for this domain.'
                    ])->withInput();
                }

                return redirect('/');
            }

            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Internal error, please try again later'. $e->getMessage()
            ], 400);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/logout');
    }
}
