<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockScreenController extends Controller
{
    public function lockScreen()
    {
        if (Auth::check()) {
            $email = Auth::user()->email;
            $name = Auth::user()->name;
            Auth::logout();
            return view('pages.lockscreen', compact(['email', 'name']));
        } else {
            return redirect('login');
        }
    }

    public function lockScreenLogin(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        } else {
            return redirect('login');
        }
    }
}
