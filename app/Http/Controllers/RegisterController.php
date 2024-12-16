<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function show()
    {
        return view ('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {

            DB::beginTransaction();

            $validated = $request->validated();

            $initials = strtoupper(substr($validated['first_name'], 0, 1) . substr($validated['last_name'], 0, 1));
            $hash = Str::random(4);

            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $domain = $initials . $hash . $user->id . '.functionalchart.com';

            $account = Account::create([
                'user_id' => $user->id,
                'title' => $user->email,
                'domain' => $domain,
            ]);

            Auth::login($user);

            DB::commit();

            return redirect('/');

        } catch (\Exception $e) {
            DB::rollback();
            return response([
                'message' => 'Internal error, please try again later' . $e->getMessage()
            ], 400);
        }
    }

}
