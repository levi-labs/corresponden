<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $title = 'Login Page';
        return view('pages.auth.login', compact('title'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth('web')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('login');
    }
}
