<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InscriptionController extends Controller
{
    public function formulaire()
    {
        return view('inscription');
    }

    public function soumettre(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'nom_entreprise' => 'required',
            'description_produit' => 'required',
        ]);

        User::create([
            'name' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nom_entreprise' => $request->nom_entreprise,
            'description_produit' => $request->description_produit,
            'role' => 'en_attente',
        ]);

        return redirect('/attente');
    }
}



