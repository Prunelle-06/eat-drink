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
        $formType = $request->input('form_type');

        if($formType === 'exposant') {
            $validated = $request->validate([
                'exposant_email' => 'required|email|unique:users,email',
                'exposant_nom_complet' => 'required|string|min:3|max:50',
                'exposant_password' => 'required|min:8|confirmed',
                'nom_stand' => 'required|string|min:3|max:50',
                'description_stand' => 'required|string|max:1000',
                'image_stand' => 'required|image|max:5120',
            ]);

            DB::transaction(function () use ($validated) {
                // creation User 
                $user = User::create([
                    'email' => $validated['exposant_email'],
                    'nom_complet' => $validated['exposant_nom_complet'],
                    'password' => Hash::make($validated['exposant_password']),
                    'type' => 'exposant'
                ]);

                // creation Stand lié à User
                Stand::create([
                    'user_id' => $user->id,
                    'nom_stand' => $validated['nom_stand'],
                    'image_stand' => $validated['image_stand'],
                    'description_stand' => $validated['description_stand'],
                    'statut' => 'en_attente',
                ]);

            });

            return redirect('/attente')->with('success', 'Votre demande a été soumise !');

        } elseif($formType === 'visiteur') {
            $validated = $request->validate([
                'visiteur_email' => 'required|email|unique:users,email',
                'visiteur_nom_complet' => 'required|string|min:3|max:50',
                'visiteur_password' => 'required|min:8',
            ]);

            User::create([
                'email' => $validated['visiteur_email'],
                'nom_complet' => $validated['visiteur_nom_complet'],
                'password' => Hash::make($validated['visiteur_password']),
                'type' => 'visiteur'
            ]);

            return redirect('/dashboard/visiteur')->with('success', 'Inscription réussie !');
        }

    }
}



