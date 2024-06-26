<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Pieteikumi;
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

        return view('profesionalis.pakalpojumi', compact('pakalpojumi'));
    }

    public function addPakalpojums(Request $request)
    {
        $request->validate([
            'nosaukums' => 'required|string|max:255',
            'apraksts' => 'required|string|max:200',
            'kategorijas_nosaukums' => 'required|string|max:50',
            'cena' => 'required|numeric|min:0',
            'adrese' => 'required|string|max:255',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Log the request data for debugging
        Log::info('Request data:', $request->all());

        $pakalpojums = Pakalpojumi::create([
            'nosaukums' => $request->nosaukums,
            'apraksts' => $request->apraksts,
            'kategorijas_nosaukums' => $request->kategorijas_nosaukums,
            'cena' => $request->cena,
            'adrese' => $request->adrese,
            'profesionalis_id' => Auth::user()->id,
        ]);

        Log::info('Service created:', $pakalpojums->toArray());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image->isValid()) {
                    Log::info('Processing image:', ['index' => $index, 'image' => $image]);
                    $path = $image->store('images', 'public');
                    $pakalpojums->images()->create(['image_path' => $path]);
                    Log::info('Image uploaded:', ['path' => $path]);
                } else {
                    Log::error('Invalid image file:', ['index' => $index, 'image' => $image]);
                }
            }
        }

        return redirect()->route('profesionalis.pakalpojumi')->with('success', 'Pakalpojums added successfully!');
    }
}
