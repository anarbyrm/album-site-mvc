<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.auth.login');
    }

    public function loginPost(LoginFormRequest $request)
    {
        $validatedData = $request->validated();
        if (Auth::attempt($validatedData)) return redirect(route('collections.index'));
        return redirect()->back()->withErrors('Email or password is invalid');
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    public function registerPost(RegisterFormRequest $request)
    {
        $validatedData = $request->validated();
        User::create($validatedData);
        return redirect(route('auth.login.get'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('auth.login.get'));
    }
}
