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

        if(Auth::check()) {

            if(Auth::id() != $stand->user_id) {
                
                $visitData = [
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->nom_complet,
                    'user_email' => Auth::user()->email,
                    'user_type' => Auth::user()->type,
                    'page_title' => $stand->nom_stand,
                    'visited_at' => now()->format('Y-m-d H:i:s')
                ];

                $stand->visit()
                  ->withData($visitData)   
                  ->dailyIntervals()
                  ->withIp()
                  ->withSession();
            }
        }

        $stand->load(['user', 'products'])->where('statut', 'approuve'); 
    
        return view('exposants.show', [
            'stand' => $stand,
            'products' => $stand->products 
        ]);
       
    }

}
