<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Profesionali;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all pakalpojumi with related lokacijas and profesionali
        $pakalpojumi = Pakalpojumi::with(['lokacija', 'profesionali'])->get();
    
        // Get unique kategorijas nosaukums
        $kategorijas = Pakalpojumi::select('kategorijas_nosaukums')->distinct()->pluck('kategorijas_nosaukums');
    
        // Pass data to the view
        return view('welcome', compact('pakalpojumi', 'kategorijas'));
    }
    
}
