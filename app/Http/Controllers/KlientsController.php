<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use Illuminate\Support\Facades\Auth;

class KlientsController extends Controller
{
    public function index()
    {
        // Fetch all pakalpojumi
        $pakalpojumi = Pakalpojumi::all();

        // Get unique kategorijas nosaukums
        $kategorijas = Pakalpojumi::select('kategorijas_nosaukums')->distinct()->pluck('kategorijas_nosaukums');

        // Get unique cities from the adrese column
        $pilsetas = Pakalpojumi::selectRaw('SUBSTRING_INDEX(adrese, ",", -1) as city')
            ->distinct()
            ->pluck('city');

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

    public function pieteikumi()
    {
        // Logic for handling the pieteikumi route
        return view('klients.klients_pieteikumi'); // This assumes you have a blade file named klients_pieteikumi.blade.php
    }
}
