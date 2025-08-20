<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class StandController extends Controller
{
    public function index() {
        $stands = Stand::with(['user', 'products'])
               ->where('statut', 'approuve')
               ->get();

        return view('exposants.index', compact('stands'));
    }


    public function show(Stand $stand) {

        $stand->load(['user', 'products'])->where('statut', 'approuve'); 
    
        return view('exposants.show', [
            'stand' => $stand,
            'products' => $stand->products 
        ]);
       
    }

}
