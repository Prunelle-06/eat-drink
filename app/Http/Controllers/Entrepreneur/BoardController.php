<?php

namespace App\Http\Controllers\Entrepreneur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use App\Models\Order;

class BoardController extends Controller
{
    public function index()
    {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
        
        $user = Auth::user();
        if (!$user->stand) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de stand.');
        }

        $userInfo = Auth::user()->load(['stand', 'products']);

        $orders = Order::with(['user', 'items'])
                      ->where('stand_id', $user->stand->id)
                      ->orderBy('created_at', 'asc')
                      ->get();

        $stats = [
            'pending' => Order::forStand($user->stand->id)->pending()->count(),
            'confirmed' => Order::forStand($user->stand->id)->confirmed()->count(),
            'total_revenue' => Order::forStand($user->stand->id)
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount')
        ];

        $current_section = 'null';

        return view('entrepreneur.dashboard', compact('userInfo', 'orders', 'stats', 'current_section'));
    }

    public function profil()
    {
        $user = auth()->user();
        $userInfo = auth()->user()->load('stand');

        $orders = Order::with(['user', 'items'])
                      ->where('stand_id', $user->stand->id)
                      ->orderBy('created_at', 'asc')
                      ->get();

        $stats = [
            'pending' => Order::forStand($user->stand->id)->pending()->count(),
            'confirmed' => Order::forStand($user->stand->id)->confirmed()->count(),
            'total_revenue' => Order::forStand($user->stand->id)
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount')
        ];
        
        $current_section = 'profil';

        return view('entrepreneur.dashboard', compact('userInfo', 'orders', 'stats', 'current_section'));
    }

    public function updateProfil(Request $request) {

        $userType = Auth::user()->type;
        
        if($userType === "exposant") {
            $user = auth()->user();

            $validated = $request->validate([
                'exposant_email' => 'required|email|unique:users,email,' . $user->id,
                'exposant_nom_complet' => 'required|string|min:3|max:50',
                'exposant_password' => 'nullable|min:8|confirmed',
                'nom_stand' => 'required|string|min:3|max:50',
                'description_stand' => 'required|string|max:1000',
                'image_stand' => 'nullable|image|max:5120',
            ]);

            DB::transaction(function () use ($validated, $request, $user) {
                // Mise à jour User
                $userData = [
                    'email' => $validated['exposant_email'],
                    'nom_complet' => $validated['exposant_nom_complet'],
                ];
                
                // Mise à jour du mot de passe seulement si fourni
                if (!empty($validated['exposant_password'])) {
                    $userData['password'] = Hash::make($validated['exposant_password']);
                }
                
                $user->update($userData);

                // Gestion de l'image
                $imageName = $user->stand->image_stand;
                if($request->hasFile('image_stand')) {
                    $image = $request->image_stand;
                    $ext = $image->getClientOriginalExtension();
                    $imageName = time().'.'.$ext;
                    $image->move(public_path('uploads/img_stands'), $imageName);

                    // Supprimer l'ancienne image
                    if($user->stand->image_stand && file_exists(public_path('uploads/img_stands/' . $user->stand->image_stand))) {
                        unlink(public_path('uploads/img_stands/' . $user->stand->image_stand));
                    }
                }

                // Mis à jour Stand
                $user->stand()->updateOrCreate(
                    ['user_id' => $user->id],
                    [   
                        'nom_stand' => $validated['nom_stand'],
                        'image_stand' => $imageName,
                        'description_stand' => $validated['description_stand'],
                    ]
                );

            });

            return redirect()->back()->with('success', 'Profil mis à jour avec succès');
        }
    }

    public function show(Stand $stand) {
        
        // if (auth()->id() !== $stand->user_id) {
        //     abort(403, 'Accès non authorisé'); 
        // }

        // $stand->load(['user.products']); 
    
        // return view('exposants.show', [
        //     'stand' => $stand,
        //     'products' => $stand->user->products     
        // ]);
       
    }

}
