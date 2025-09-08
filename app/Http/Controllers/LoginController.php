<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use App\Models\Stand;

class LoginController extends Controller
{
    public function index() {
        return view("login");
    } 
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
            
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects',
            ])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();
        
        if($user->isExposant()) {
            $stand = $user->stand;

            // Vérifier que l'exposant a bien un stand
            if (!$stand) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte exposant n\'est pas configuré correctement.',
                ]);
            }
            // Redirection selon le statut
            return match($stand->statut) {
                'approuve' => redirect()->intended('/dashboard/exposant'),
                'en_attente' => redirect('/attente'),
                'rejete' => redirect('/login')->withErrors(['email' => 'Votre demande a été rejetée.']),
                default => redirect('/attente')
            };
        } else if($user->isVisiteur()) {
            return redirect('/dashboard/visiteur');
        } 
        else if($user->isAdmin()) {
            return redirect('/admin');
        }


    }

}
