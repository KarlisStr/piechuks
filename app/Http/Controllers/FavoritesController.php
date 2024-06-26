<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function save($id)
    {
        $user = Auth::user();

        // Check if the service is already in favorites
        $exists = Favorite::where('user_id', $user->id)->where('pakalpojuma_id', $id)->exists();

        if ($exists) {
            return response()->json(['message' => 'Service already in favorites'], 200);
        }

        // Save to favorites
        Favorite::create([
            'user_id' => $user->id,
            'pakalpojuma_id' => $id,
        ]);

        return response()->json(['message' => 'Service added to favorites successfully!'], 200);
    }
}
