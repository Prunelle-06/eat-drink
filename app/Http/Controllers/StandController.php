<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Stand;

class StandController extends Controller
{
    public function index() {
        // Charger le propriétaire du stand
        $stands = User::where('role', 'entrepreneur_approuve')
                    ->with('stand')
                    ->get();

        return view('exposant', [
            'stands' => $stands 
        ]);
    }

    public function show(Stand $stand) {
        // Charge les produits du stand
        
    }
}
