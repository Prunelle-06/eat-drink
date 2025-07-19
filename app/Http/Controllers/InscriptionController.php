<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    public function formulaire()
    {
        return view('register');
    }

    public function soumettre(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'nom_entreprise' => 'required|string|max:255',
            'nom_stand' => 'required|string|max:255',
            'description_stand' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // creation User 
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nom_entreprise' => $validated['nom_entreprise'],
                'role' => 'entrepreneur_en_attente',
            ]);

            // creation Stand lié à User
            Stand::create([
                'user_id' => $user->id,
                'nom_stand' => $validated['nom_stand'],
                'description_stand' => $validated['description_stand'],
            ]);

        });

        return redirect('/attente')->with('success', 'Votre demande a été soumise !');
    }
}



