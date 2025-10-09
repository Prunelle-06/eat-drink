<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Stand;
use Coderflex\Laravisit\Models\Visit;
use Illuminate\Support\Facades\Auth;

class BoardVisitorController extends Controller
{
    public function index()
    {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }

        if (Auth::check() && Auth::user()->type === 'visiteur') {
            $user = Auth::user();
            
            $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();

            $ordersReady = Order::where('user_id', Auth::id())
                     ->whereNotNull('pickup_code')
                     ->where('status', 'ready')
                     ->where('code_used', false)
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            
            $ordersConfirmed = Order::where('user_id', Auth::id())
                     ->whereNotNull('delivered_at')
                     ->where('status', 'confirmed')
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            
            $stands = Stand::where('statut', 'approuve')->get();

            $favorites = $user->favoriteStands()->with(['user', 'products'])->paginate(4);

            $myVisits = Visit::where('visitable_type', Stand::class)
                                  ->where('data->user_id', $user->id)
                                  ->distinct('visitable_id')
                                  ->count();

            $myVisitsThisWeek = Visit::where('visitable_type', Stand::class)
                         ->where('created_at', '>=', now()->subWeek())
                         ->where('data->user_id', $user->id) 
                         ->distinct('visitable_id')
                         ->count();

            $statsOrders = [
                'pending' => Order::forClient(Auth::id())->pending()->count(),
                'delivered' => Order::forClient(Auth::id())->delivered()->count(),
                'ready' => Order::forClient(Auth::id())->ready()->count(),
                'confirmed' => Order::forClient(Auth::id())->confirmed()->count(),
                'cancelled' => Order::forClient(Auth::id())->cancelled()->count(),
                
                'myOrdersPending' => Order::where('user_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->sum('total_amount'),

                'myOrdersConfirmed' => Order::where('user_id', Auth::id())
                                    ->where('status', 'confirmed')
                                    ->sum('total_amount'),

                'myOrdersReady' => Order::where('user_id', Auth::id())
                                    ->where('status', 'ready')
                                    ->sum('total_amount'),

                'myOrdersDelivered' => Order::where('user_id', Auth::id())
                                    ->where('status', 'delivered')
                                    ->sum('total_amount'),

                'myOrdersCancelled' => Order::where('user_id', Auth::id())
                                    ->where('status', 'cancelled')
                                    ->sum('total_amount'),

            ];
                                
            $current_section = 'index';
        } 

        return view('visiteur.dashboard', compact(
            'user', 
            'orders', 
            'ordersConfirmed', 
            'ordersReady', 
            'stands', 
            'favorites', 
            'myVisits',  
            'myVisitsThisWeek',   
            'statsOrders',
            'current_section'
        ));
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

            $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();

            $ordersReady = Order::where('user_id', Auth::id())
                     ->whereNotNull('pickup_code')
                     ->where('status', 'ready')
                     ->where('code_used', false)
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            
            $ordersConfirmed = Order::where('user_id', Auth::id())
                     ->whereNotNull('delivered_at')
                     ->where('status', 'confirmed')
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            
            $stands = Stand::where('statut', 'approuve')->get();

            $user = Auth::user();
            $favorites = $user->favoriteStands()->with(['user', 'products'])->paginate(4);

            $myVisits = Visit::where('visitable_type', Stand::class)
                                  ->where('data->user_id', $user->id)
                                  ->distinct('visitable_id')
                                  ->count();

            $myVisitsThisWeek = Visit::where('visitable_type', Stand::class)
                         ->where('created_at', '>=', now()->subWeek())
                         ->where('data->user_id', $user->id) 
                         ->distinct('visitable_id')
                         ->count();

            $statsOrders = [
                'pending' => Order::forClient(Auth::id())->pending()->count(),
                'delivered' => Order::forClient(Auth::id())->delivered()->count(),
                'ready' => Order::forClient(Auth::id())->ready()->count(),
                'confirmed' => Order::forClient(Auth::id())->confirmed()->count(),
                'cancelled' => Order::forClient(Auth::id())->cancelled()->count(),
                
                'myOrdersPending' => Order::where('user_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->sum('total_amount'),

                'myOrdersConfirmed' => Order::where('user_id', Auth::id())
                                    ->where('status', 'confirmed')
                                    ->sum('total_amount'),

                'myOrdersReady' => Order::where('user_id', Auth::id())
                                    ->where('status', 'ready')
                                    ->sum('total_amount'),

                'myOrdersDelivered' => Order::where('user_id', Auth::id())
                                    ->where('status', 'delivered')
                                    ->sum('total_amount'),

                'myOrdersCancelled' => Order::where('user_id', Auth::id())
                                    ->where('status', 'cancelled')
                                    ->sum('total_amount'),

            ];

            $current_section = 'profil';
        }

        return view('visiteur.dashboard', compact(
            'user', 
            'orders', 
            'ordersConfirmed', 
            'ordersReady', 
            'stands', 
            'favorites', 
            'myVisits',  
            'myVisitsThisWeek',   
            'statsOrders',
            'current_section'
        ));
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

    public function ordersReady() {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }

        if (Auth::check() && Auth::user()->type === 'visiteur') {
            $user = Auth::user();
            
            $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();

            $ordersReady = Order::where('user_id', Auth::id())
                     ->whereNotNull('pickup_code')
                     ->where('status', 'ready')
                     ->where('code_used', false)
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();

            $ordersConfirmed = Order::where('user_id', Auth::id())
                     ->whereNotNull('delivered_at')
                     ->where('status', 'confirmed')
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            
            $stands = Stand::where('statut', 'approuve')->get();

            $favorites = $user->favoriteStands()->with(['user', 'products'])->paginate(4);

            $myVisits = Visit::where('visitable_type', Stand::class)
                                  ->where('data->user_id', $user->id)
                                  ->distinct('visitable_id')
                                  ->count();

            $myVisitsThisWeek = Visit::where('visitable_type', Stand::class)
                         ->where('created_at', '>=', now()->subWeek())
                         ->where('data->user_id', $user->id) 
                         ->distinct('visitable_id')
                         ->count();

            $statsOrders = [
                'pending' => Order::forClient(Auth::id())->pending()->count(),
                'delivered' => Order::forClient(Auth::id())->delivered()->count(),
                'ready' => Order::forClient(Auth::id())->ready()->count(),
                'confirmed' => Order::forClient(Auth::id())->confirmed()->count(),
                'cancelled' => Order::forClient(Auth::id())->cancelled()->count(),
                
                'myOrdersPending' => Order::where('user_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->sum('total_amount'),

                'myOrdersConfirmed' => Order::where('user_id', Auth::id())
                                    ->where('status', 'confirmed')
                                    ->sum('total_amount'),

                'myOrdersReady' => Order::where('user_id', Auth::id())
                                    ->where('status', 'ready')
                                    ->sum('total_amount'),

                'myOrdersDelivered' => Order::where('user_id', Auth::id())
                                    ->where('status', 'delivered')
                                    ->sum('total_amount'),

                'myOrdersCancelled' => Order::where('user_id', Auth::id())
                                    ->where('status', 'cancelled')
                                    ->sum('total_amount'),

            ];
                                
            $current_section = 'ordersReady';
        } 

        return view('visiteur.dashboard', compact(
            'user', 
            'orders', 
            'ordersConfirmed', 
            'ordersReady', 
            'stands', 
            'favorites', 
            'myVisits',  
            'myVisitsThisWeek',   
            'statsOrders',
            'current_section'
        ));
    }

    public function ordersConfirmed() {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }

        if (Auth::check() && Auth::user()->type === 'visiteur') {
            $user = Auth::user();
            
            $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();

            $ordersReady = Order::where('user_id', Auth::id())
                     ->where('status', 'ready')
                     ->where('code_used', false)
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();

            $ordersConfirmed = Order::where('user_id', Auth::id())
                     ->where('status', 'confirmed')
                     ->with(['user', 'stand', 'items'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            
            $stands = Stand::where('statut', 'approuve')->get();

            $favorites = $user->favoriteStands()->with(['user', 'products'])->paginate(4);

            $myVisits = Visit::where('visitable_type', Stand::class)
                                  ->where('data->user_id', $user->id)
                                  ->distinct('visitable_id')
                                  ->count();

            $myVisitsThisWeek = Visit::where('visitable_type', Stand::class)
                         ->where('created_at', '>=', now()->subWeek())
                         ->where('data->user_id', $user->id) 
                         ->distinct('visitable_id')
                         ->count();

            $statsOrders = [
                'pending' => Order::forClient(Auth::id())->pending()->count(),
                'delivered' => Order::forClient(Auth::id())->delivered()->count(),
                'ready' => Order::forClient(Auth::id())->ready()->count(),
                'confirmed' => Order::forClient(Auth::id())->confirmed()->count(),
                'cancelled' => Order::forClient(Auth::id())->cancelled()->count(),
                
                'myOrdersPending' => Order::where('user_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->sum('total_amount'),

                'myOrdersConfirmed' => Order::where('user_id', Auth::id())
                                    ->where('status', 'confirmed')
                                    ->sum('total_amount'),

                'myOrdersReady' => Order::where('user_id', Auth::id())
                                    ->where('status', 'ready')
                                    ->sum('total_amount'),

                'myOrdersDelivered' => Order::where('user_id', Auth::id())
                                    ->where('status', 'delivered')
                                    ->sum('total_amount'),

                'myOrdersCancelled' => Order::where('user_id', Auth::id())
                                    ->where('status', 'cancelled')
                                    ->sum('total_amount'),

            ];
                                
            $current_section = 'ordersConfirmed';
        } 

        return view('visiteur.dashboard', compact(
            'user', 
            'orders', 
            'ordersConfirmed', 
            'ordersReady', 
            'stands', 
            'favorites', 
            'myVisits',  
            'myVisitsThisWeek',   
            'statsOrders',
            'current_section'
        ));
    }
}
