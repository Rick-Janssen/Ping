<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:40'],
            'email' => ['required', 'max:40', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/home')->with('message', 'User created and logged in');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'max:40', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/home')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'new_password' => 'required|confirmed|min:6'
        ]);

        if (auth()->attempt($formFields)) {
            $password = bcrypt($formFields['new_password']);
            User::where('email', $request->email)
                ->update(
                    [
                        'email' => $request->email,
                        'password' => $password,
                    ]
                );

            return redirect('/account-settings')->with('message', 'Password changed');
        } else {
            return back()->withErrors(['password' => 'Invalid Credentials'])->onlyInput('password');
        };
    }
    public function accountSettings()
    {
        $settings = Settings::first();

        return view('users/accountsettings', compact('settings'));
    }
}
