<?php

namespace App\Http\Controllers\Entrepreneur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Stand;
use App\Models\Product;
use App\Models\Order;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('entrepreneur.dashboard', compact('userInfo', 'orders', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
