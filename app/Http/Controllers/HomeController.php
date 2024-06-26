<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all pakalpojumi
        $pakalpojumi = Pakalpojumi::all();

        // Get unique kategorijas nosaukums
        $kategorijas = Pakalpojumi::select('kategorijas_nosaukums')->distinct()->pluck('kategorijas_nosaukums');

        // 'adrese' data looks like this: street name, house number, city
        // Get unique cities (last word of adrese column)
        $adreses = Pakalpojumi::select('adrese')->distinct()->pluck('adrese');
        $pilsetas = $adreses->map(function ($adrese) {
            $parts = explode(',', $adrese);
            return trim(end($parts));
        })->unique();

        // Check if the user is authenticated and redirect to the appropriate home page
        if (Auth::check()) {
            if (Auth::user()->is_professional) {
                return redirect()->route('profesionalis.pieteikumi');
            } else {
                return view('klients.index', compact('pakalpojumi', 'kategorijas', 'pilsetas'));
            }
        } else {
            return view('welcome', compact('pakalpojumi', 'kategorijas', 'pilsetas'));
        }
    }
}
