<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }
    public function showLogin() {
        return view('auth.login');
    }
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);
        try {
            Auth::login($user);
        } catch (\Exception $e) {
            return redirect()->route('register')->withErrors(['errors' => $e->getMessage()]);
        }
        return redirect()->route('books.index');
    }
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if (Auth::attempt($validated)) {
            return redirect()->route('books.index');
        }
        return redirect()->route('login')->withErrors(['errors' => 'Invalid credentials']);

    }

    public function logout(Request $request){
        Auth::logout();

        //invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
