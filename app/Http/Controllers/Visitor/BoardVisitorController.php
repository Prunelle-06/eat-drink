<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class BoardVisitorController extends Controller
{
    public function index()
    {
        $orders = Order::with(['stand.user', 'items'])
                      ->where('user_id', Auth::id())
                      ->orderBy('created_at', 'asc')
                      ->get();
            
        $stands = Stand::where('statut', 'approuve')->get();

        return view('visiteur.dashboard', compact('orders', 'stands'));
    }
}
