<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\EntrepreneurApprovedNotification;

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

        // Envoi de la notification
        $user->notify(new EntrepreneurApprovedNotification(
            $user->nom_entreprise,
            $user->stand->nom_stand
        ));

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
