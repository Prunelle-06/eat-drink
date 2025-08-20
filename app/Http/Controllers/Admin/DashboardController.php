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
            'pendingCount' => Stand::where('statut', 'en_attente')->count(), 
            'approvedCount' => Stand::where('statut', 'approuve')->count(), 
            'pendingRequests' => Stand::with('user')->where('statut', 'en_attente')->get(), 
        ]);
    }


    public function approve($id)
    {
        $stand = Stand::with('user')->findOrFail($id);
        $stand->update(['statut' => 'approuve']);

        // Envoi de la notification
        if($stand->user) {
            $stand->user->notify(new EntrepreneurApprovedNotification(
                $stand->user->nom_complet,
                $stand->nom_stand
            ));
        }

        return back()->with('success', "Le stand {$stand->nom_stand} a été approuvé !");
    }

    // Rejette une demande 
    public function reject($id)
    {
        DB::transaction(function () use ($id) {
            $stand = Stand::with('user')->findOrFail($id);

            if ($stand->user) {
                $stand->user->delete();
            }
            $stand->delete();
        });

        return back()->with('success', "La demande a été rejetée.");
    }

}
