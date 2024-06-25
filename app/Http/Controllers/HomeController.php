<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all pakalpojumi
        $pakalpojumi = Pakalpojumi::all();

        // Get unique kategorijas nosaukums
        $kategorijas = Pakalpojumi::select('kategorijas_nosaukums')->distinct()->pluck('kategorijas_nosaukums');

        // Pass data to the view
        return view('welcome', compact('pakalpojumi', 'kategorijas'));
    }
}
