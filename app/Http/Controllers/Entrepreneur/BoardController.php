<?php

namespace App\Http\Controllers\Entrepreneur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Stand;
use App\Models\StandFavorite;
use App\Models\Product;
use App\Models\Order;
use Coderflex\Laravisit\Models\Visit;
use Carbon\Carbon;

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
                      ->orderBy('created_at', 'desc')
                      ->get();

        $stats = [
            'pending' => Order::forStand($user->stand->id)->pending()->count(),
            'delivered' => Order::forStand($user->stand->id)->delivered()->count(),
            'ready' => Order::forStand($user->stand->id)->ready()->count(),
            'confirmed' => Order::forStand($user->stand->id)->confirmed()->count(),

            'ca_réalisé' => Order::forStand($user->stand->id)
                                   ->where('status', 'delivered')
                                   ->sum('total_amount'),

            'ca_confirmé' => Order::forStand($user->stand->id)
                                   ->where('status', 'confirmed')
                                   ->sum('total_amount'),

            'ca_pret' => Order::forStand($user->stand->id)
                                   ->ready()
                                   ->sum('total_amount'),

            'ca_non_confirmé' => Order::forStand($user->stand->id)
                                   ->where('status', 'pending')
                                   ->sum('total_amount'),

            'ca_total' => Order::forStand($user->stand->id)
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount'),
                                   

            'produit_plus_rentable' => Product::join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.stand_id', $user->stand->id)  
            ->where('orders.status', 'delivered')
            ->selectRaw('
                products.id,
                products.nom_produit,
                products.prix,
                SUM(order_items.quantity * (order_items.product_price - products.prix)) as total_profit
            ')
            ->groupBy('products.id', 'products.nom_produit', 'products.prix')
            ->orderBy('total_profit', 'desc')
            ->first(),

        ];

        // Chargez le stand avec le count des favoris
        $user->load(['stand' => function($query) {
            $query->withCount('favoritedBy');
        }]);

        $totalFavorites = $user->stand ? $user->stand->favorited_by_count : 0;
        $favoritesThisWeek = $user->stand ? 
            StandFavorite::where('stand_id', $user->stand->id)
                ->where('created_at', '>=', now()->subWeek())
                ->count() : 0;

        $stand = $user->stand;
        $allVisits = Visit::where('visitable_type', Stand::class)
                         ->where('visitable_id', $stand->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        $visitesToday = $allVisits->where('created_at', '>=', Carbon::today())->count();

        $current_section = 'index';

        return view('entrepreneur.dashboard', compact(
            'userInfo', 
            'orders', 
            'stats', 
            'totalFavorites', 
            'favoritesThisWeek', 
            'allVisits',
            'visitesToday',
            'current_section'
        ));
    }

    public function profil()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
        
        $user = auth()->user();
        $userInfo = auth()->user()->load('stand');

        if (!$user->stand) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de stand.');
        }

        $orders = Order::with(['user', 'items'])
                      ->where('stand_id', $user->stand->id)
                      ->orderBy('created_at', 'desc')
                      ->get();

        $stats = [
            'pending' => Order::forStand($user->stand->id)->pending()->count(),
            'confirmed' => Order::forStand($user->stand->id)->confirmed()->count(),
            'ready' => Order::forStand($user->stand->id)->ready()->count(),
            'delivered' => Order::forStand($user->stand->id)->delivered()->count(),

            'ca_réalisé' => Order::forStand($user->stand->id)
                                   ->delivered()
                                   ->sum('total_amount'),

            'ca_confirmé' => Order::forStand($user->stand->id)
                                   ->confirmed()
                                   ->sum('total_amount'),

            'ca_pret' => Order::forStand($user->stand->id)
                                   ->ready()
                                   ->sum('total_amount'),

            'ca_non_confirmé' => Order::forStand($user->stand->id)
                                   ->pending()
                                   ->sum('total_amount'),

            'ca_total' => Order::forStand($user->stand->id)
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount'),
                                   

            'produit_plus_rentable' => Product::join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.stand_id', $user->stand->id)  
            ->where('orders.status', 'delivered')
            ->selectRaw('
                products.id,
                products.nom_produit,
                products.prix,
                SUM(order_items.quantity * (order_items.product_price - products.prix)) as total_profit
            ')
            ->groupBy('products.id', 'products.nom_produit', 'products.prix')
            ->orderBy('total_profit', 'desc')
            ->first(),
        
        ];

        // Chargez le stand avec le count des favoris
        $user->load(['stand' => function($query) {
            $query->withCount('favoritedBy');
        }]);

        $totalFavorites = $user->stand ? $user->stand->favorited_by_count : 0;
        $favoritesThisWeek = $user->stand ? 
            StandFavorite::where('stand_id', $user->stand->id)
                ->where('created_at', '>=', now()->subWeek())
                ->count() : 0;

        $stand = $user->stand;
        $allVisits = Visit::where('visitable_type', Stand::class)
                         ->where('visitable_id', $stand->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        $visitesToday = $allVisits->where('created_at', '>=', Carbon::today())->count();
        
        $current_section = 'profil';

        return view('entrepreneur.dashboard', compact(
            'userInfo', 
            'orders', 
            'stats', 
            'totalFavorites', 
            'favoritesThisWeek', 
            'allVisits',
            'visitesToday',
            'current_section'
        ));
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

    public function fastCodeValidation()
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
                      ->orderBy('created_at', 'desc')
                      ->get();

        $stats = [
            'pending' => Order::forStand($user->stand->id)->pending()->count(),
            'delivered' => Order::forStand($user->stand->id)->delivered()->count(),
            'ready' => Order::forStand($user->stand->id)->ready()->count(),
            'confirmed' => Order::forStand($user->stand->id)->confirmed()->count(),

            'ca_réalisé' => Order::forStand($user->stand->id)
                                   ->where('status', 'delivered')
                                   ->sum('total_amount'),

            'ca_confirmé' => Order::forStand($user->stand->id)
                                   ->where('status', 'confirmed')
                                   ->sum('total_amount'),

            'ca_pret' => Order::forStand($user->stand->id)
                                   ->ready()
                                   ->sum('total_amount'),

            'ca_non_confirmé' => Order::forStand($user->stand->id)
                                   ->where('status', 'pending')
                                   ->sum('total_amount'),

            'ca_total' => Order::forStand($user->stand->id)
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount'),
                                   

            'produit_plus_rentable' => Product::join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.stand_id', $user->stand->id)  
            ->where('orders.status', 'delivered')
            ->selectRaw('
                products.id,
                products.nom_produit,
                products.prix,
                SUM(order_items.quantity * (order_items.product_price - products.prix)) as total_profit
            ')
            ->groupBy('products.id', 'products.nom_produit', 'products.prix')
            ->orderBy('total_profit', 'desc')
            ->first(),

        ];

        // Chargez le stand avec le count des favoris
        $user->load(['stand' => function($query) {
            $query->withCount('favoritedBy');
        }]);

        $totalFavorites = $user->stand ? $user->stand->favorited_by_count : 0;
        $favoritesThisWeek = $user->stand ? 
            StandFavorite::where('stand_id', $user->stand->id)
                ->where('created_at', '>=', now()->subWeek())
                ->count() : 0;

        $stand = $user->stand;
        $allVisits = Visit::where('visitable_type', Stand::class)
                         ->where('visitable_id', $stand->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        $visitesToday = $allVisits->where('created_at', '>=', Carbon::today())->count();

        $current_section = 'fastCodeValidation';

        return view('entrepreneur.dashboard', compact(
            'userInfo', 
            'orders', 
            'stats', 
            'totalFavorites', 
            'favoritesThisWeek', 
            'allVisits',
            'visitesToday',
            'current_section'
        ));
    }

    public function findOrderByCode(Request $request)
    {
        $request->validate([
            'pickup_code' => 'required|digits:4'
        ]);

        $order = Order::where('pickup_code', $request->pickup_code)
                     ->where('status', 'ready')
                     ->where('code_used', false)
                     ->with(['user', 'stand', 'items'])
                     ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune commande trouvée avec ce code'
            ], 404);
        }

        // Vérifier que c'est le bon exposant
        if ($order->stand->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Ce code ne correspond pas à vos commandes'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'stand_name' => $order->stand->nom_stand,
                'client_name' => $order->user->nom_complet,
                'total_amount' => $order->total_amount,
                'items_count' => $order->items->count(),
                'code' => $order->pickup_code,
                'created_at' => $order->created_at->format('d/m/Y H:i')
            ]
        ]);
    }

    public function validatePickupCode(Request $request, Order $order)
    {
        $request->validate([
            'pickup_code' => 'required|digits:4'
        ]);

        if ($order->stand->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        if ($order->status !== 'ready') {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande n\'est pas prête pour retrait'
            ], 400);
        }

        if ($order->code_used) {
            return response()->json([
                'success' => false,
                'message' => 'Ce code a déjà été utilisé'
            ], 400);
        }

        // Vérifier le code
        if ($request->pickup_code != $order->pickup_code) {
            return response()->json([
                'success' => false,
                'message' => 'Code de retrait incorrect'
            ], 400);
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
            'code_used' => true
        ]);

        // Envoyer notification au client
        \OneSignal::sendNotificationToExternalUser(
            "Le stand {$order->stand->nom_stand}, a validé la livraison de votre commande {$order->order_number}",
            (string)$order->user_id, 
            route('home'),
            [
                'order_id' => $order->id,
                'type' => 'order_delivered'
            ]
        );

        return response()->json([
            'success' => true,
            'message' => "Commande {$order->order_number} de {$order->user->nom_complet} livrée avec succès !",
            'client_name' => $order->user->nom_complet,
            'order_number' => $order->order_number
        ]);
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
