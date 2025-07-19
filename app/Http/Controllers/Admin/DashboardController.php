<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard', [
            'pendingCount' => User::where('role', 'entrepreneur_en_attente')->count(), 
            'approvedCount' => User::where('role', 'entrepreneur_approuve')->count(), 
            'pendingRequests' => User::with('stand')->where('role', 'entrepreneur_en_attente')->get(), 
        ]);
    }

    // Approuve une demande  
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => 'entrepreneur_approuve']);

        return back()->with('success', "Le stand {$user->nom_entreprise} a été approuvé !");
    }

    // Rejette une demande 
    public function reject($id)
    {
        DB::transaction(function () use ($id) {
            Stand::where('user_id', $id)->delete();     
            User::findOrFail($id)->delete();
        });

        return back()->with('success', "La demande a été rejetée.");
    }

}
