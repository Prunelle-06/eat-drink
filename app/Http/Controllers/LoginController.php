<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return view("login");
    } 
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
            
        Auth::login($user);
        $request->session()->regenerate();
        
        // Redirection selon le rôle
        return match($user->role) {
            'admin' => redirect()->intended('/admin'),
            'entrepreneur_approuve' => redirect()->intended('/dashboard'),
            'entrepreneur_en_attente' => redirect('/attente')
        };


        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects',
            ])->onlyInput('email');
        }
    }

}
