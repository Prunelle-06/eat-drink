<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class StandController extends Controller
{
    public function index() {
        $users = User::with(['stand', 'products'])
               ->where('role', 'entrepreneur_approuve')
               ->has('stand')
               ->get();

        return view('exposants.index', compact('users'));
    }


    public function show(Stand $stand) {

        $stand->load(['user.products']); 
    
        return view('exposants.show', [
            'stand' => $stand,
            'products' => $stand->user->products 
        ]);
       
    }

}
