<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function serviceDetails($id)
    {
        // Fetch the service with its professional and images
        $pakalpojums = Pakalpojumi::with(['profesionali.user.profileImage', 'images'])->find($id);
    
        if (!$pakalpojums) {
            return response()->json(['message' => 'Service not found'], 404);
        }
    
        return response()->json([
            'id' => $pakalpojums->pakalpojuma_id,
            'title' => $pakalpojums->nosaukums,
            'description' => $pakalpojums->apraksts,
            'category' => $pakalpojums->kategorijas_nosaukums,
            'price' => $pakalpojums->cena,
            'address' => $pakalpojums->adrese,
            'professional' => [
                'name' => $pakalpojums->profesionali ? $pakalpojums->profesionali->vards_uzvards : 'No professional assigned',
                'email' => $pakalpojums->profesionali ? $pakalpojums->profesionali->epasts : 'No email provided',
                'profileImage' => $pakalpojums->profesionali && $pakalpojums->profesionali->user && $pakalpojums->profesionali->user->profileImage ? asset('storage/' . $pakalpojums->profesionali->user->profileImage->image_path) : asset('images/default-profile.png'),
            ],
            'images' => $pakalpojums->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->image_path)
                ];
            })
        ]);
    }
}