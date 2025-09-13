<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class BoardVisitorController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->type === 'visiteur') {
            $user = Auth::user();
            
            $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();
            
            $stands = Stand::where('statut', 'approuve')->get();

            $user = Auth::user();
            $favorites = $user->favoriteStands()->with(['user', 'products'])->paginate(4);
        
            $current_section = 'null';
        }

        return view('visiteur.dashboard', compact('user', 'orders', 'stands', 'favorites', 'current_section'));
    }

    public function showFavoriteStand(StandFavorite $stand) {

        $stand->load(['user', 'products'])->where('statut', 'approuve'); 
    
        return view('exposants.show', [
            'stand' => $stand,
            'products' => $stand->products 
        ]);
       
    }

    public function profil() {

        if (Auth::check() && Auth::user()->type === 'visiteur') {
            $user = Auth::user();
            
            $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();
            
            $stands = Stand::where('statut', 'approuve')->get();

            $user = Auth::user();
            $favorites = $user->favoriteStands()->with(['user', 'products'])->paginate(4);

            $current_section = 'profil';
        }

        return view('visiteur.dashboard', compact('user', 'orders', 'stands', 'favorites', 'current_section'));
    }

    public function updateProfil(Request $request) {
        $userType = Auth::user()->type;

        if($userType === "visiteur") {
            $user = auth()->user();

            $validated = $request->validate([
                'visiteur_email' => 'required|email|unique:users,email,' . $user->id,
                'visiteur_nom_complet' => 'required|string|min:3|max:50',
                'visiteur_password' => 'nullable|min:8|confirmed',
            ]);

            DB::transaction(function () use ($validated, $request, $user) {
                // Mise à jour User
                $userData = [
                    'email' => $validated['visiteur_email'],
                    'nom_complet' => $validated['visiteur_nom_complet'],
                ];
                
                // Mise à jour du mot de passe seulement si fourni
                if (!empty($validated['visiteur_password'])) {
                    $userData['password'] = Hash::make($validated['visiteur_password']);
                }

                $user->update($userData);

            });
        }
    }
}
