<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Pakalpojumi::query();
    
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }
    
        $pakalpojumi = $query->paginate(10);
    
        // Get unique kategorijas nosaukums
        $kategorijas = Pakalpojumi::select('kategorijas_nosaukums')->distinct()->pluck('kategorijas_nosaukums');
    
        // Get unique cities from the adrese column
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