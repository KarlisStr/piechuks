<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Pieteikumi;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfesionalisController extends Controller
{
    public function index()
    {
        return redirect()->route('profesionalis.pakalpojumi');
    }

    public function pieteikumi()
    {
        $profesionalisId = Auth::user()->id;
        $pieteikumi = Pieteikumi::whereHas('pakalpojums', function($query) use ($profesionalisId) {
            $query->where('profesionalis_id', $profesionalisId);
        })->get();

        return view('profesionalis.pieteikumi', compact('pieteikumi'));
    }

    public function pakalpojumi()
    {
        $profesionalisId = Auth::user()->id;
        $pakalpojumi = Pakalpojumi::where('profesionalis_id', $profesionalisId)->get();
        // 'adrese' column from pakalpojumi table
        $locations = Pakalpojumi::select('adrese')->where('profesionalis_id', $profesionalisId)->get();

        return view('profesionalis.pakalpojumi', compact('pakalpojumi', 'locations'));
    }

    public function addPakalpojums(Request $request)
    {
        $request->validate([
            'nosaukums' => 'required|string|max:255',
            'apraksts' => 'required|string|max:200',
            'kategorijas_nosaukums' => 'required|string|max:50',
            'cena' => 'required|numeric|min:0',
            'adrese' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $pakalpojums = Pakalpojumi::create([
            'nosaukums' => $request->nosaukums,
            'apraksts' => $request->apraksts,
            'kategorijas_nosaukums' => $request->kategorijas_nosaukums,
            'cena' => $request->cena,
            'adrese' => $request->adrese,
            'profesionalis_id' => Auth::user()->id,
        ]);
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $pakalpojums->images()->create(['image_path' => $path]);
            }
        }
    
        return redirect()->route('profesionalis.pakalpojumi')->with('success', 'Pakalpojums added successfully!');
    }
}

