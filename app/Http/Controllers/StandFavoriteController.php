<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandFavorite;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class StandFavoriteController extends Controller
{
    public function toggleFavorite(Request $request, Stand $stand)
    {
        $user = Auth::user();
        
        if ($user->hasFavorited($stand->id)) {
            $user->favoriteStands()->detach($stand->id);
            $isFavorited = false;
        } else {
            $user->favoriteStands()->attach($stand->id);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'favorites_count' => $stand->favorites_count,
            'message' => $isFavorited ? 'Stand ajouté aux favoris' : 'Stand retiré des favoris'
        ]);
    }

}
