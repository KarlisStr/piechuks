<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Pieteikumi;
use Illuminate\Support\Facades\Auth;

class KlientsController extends Controller
{
    public function index()
{
    $pakalpojumi = Pakalpojumi::paginate(10);

    // Get unique kategorijas nosaukums
    $kategorijas = Pakalpojumi::select('kategorijas_nosaukums')->distinct()->pluck('kategorijas_nosaukums');

    // Get unique cities from the adrese column
    $adreses = Pakalpojumi::select('adrese')->distinct()->pluck('adrese');
    $pilsetas = $adreses->map(function ($adrese) {
        $parts = explode(',', $adrese);
        return trim(end($parts));
    })->unique();

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

    public function pieteikties(Request $request)
    {
        $request->validate([
            'apraksts' => 'required|string|max:200',
            'laiks' => 'required|date|after:now',
            'pakalpojuma_id' => 'required|exists:pakalpojumi,pakalpojuma_id',
        ]);

        Pieteikumi::create([
            'apraksts' => $request->apraksts,
            'laiks' => $request->laiks,
            'pakalpojuma_id' => $request->pakalpojuma_id,
            'klients_id' => Auth::user()->id,
            'statuss' => 0, // Unapproved by default
        ]);

        return redirect()->route('klients.pieteikumi')->with('success', 'Pieteikums created successfully!');
    }

    public function pieteikumi(Request $request)
    {
        $klientsId = Auth::user()->id;
        $query = Pieteikumi::with('pakalpojums')
            ->where('klients_id', $klientsId);
    
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }
    
        $pieteikumi = $query->paginate(10);
        
        return view('klients.pieteikumi', compact('pieteikumi'));
    }

    public function getPieteikumsDetails($pieteikumsId)
    {
        $pieteikums = Pieteikumi::findOrFail($pieteikumsId);
        $pakalpojums = Pakalpojumi::with('profesionali')->findOrFail($pieteikums->pakalpojuma_id);
        $professional = $pakalpojums->profesionali;


        return response()->json([
            'title' => $pakalpojums->nosaukums,
            'description' => $pieteikums->apraksts,
            'price' => $pakalpojums->cena,
            'laiks' => $pieteikums->laiks,
            'statuss' => $pieteikums->statuss,
            'professional' => [
                'name' => $pakalpojums->profesionali ? $pakalpojums->profesionali->vards_uzvards : 'No professional assigned',
                'email' => $pakalpojums->profesionali ? $pakalpojums->profesionali->epasts : 'No email provided',
                'profileImage' => $pakalpojums->profesionali && $pakalpojums->profesionali->user && $pakalpojums->profesionali->user->profileImage ? asset('storage/' . $pakalpojums->profesionali->user->profileImage->image_path) : asset('images/default-profile.png'),
            ],  
            'images' => $pakalpojums->images->map(function ($image) {
                return ['url' => asset('storage/' . $image->image_path)];
            })
        ]);
    }
}