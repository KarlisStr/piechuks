<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Pieteikumi;
use App\Models\Lokacijas;
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
        $locations = Lokacijas::all();

        return view('profesionalis.pakalpojumi', compact('pakalpojumi', 'locations'));
    }

    public function addPakalpojums(Request $request)
    {
        $request->validate([
            'nosaukums' => 'required|string|max:255',
            'apraksts' => 'required|string|max:200',
            'kategorijas_nosaukums' => 'required|string|in:Mājas Pakalpojumi,IT Pakalpojumi',
            'cena' => 'required|numeric|min:0',
            'adrese' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the service with address
        $pakalpojums = Pakalpojumi::create([
            'nosaukums' => $request->nosaukums,
            'apraksts' => $request->apraksts,
            'kategorijas_nosaukums' => $request->kategorijas_nosaukums,
            'cena' => $request->cena,
            'adrese' => $request->adrese,
            'profesionalis_id' => Auth::user()->id,
        ]);

        // Log the service data
        Log::info('Service created', ['pakalpojums' => $pakalpojums]);

        // Handle file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');

                Image::create([
                    'imageable_id' => $pakalpojums->id,
                    'imageable_type' => Pakalpojumi::class,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('profesionalis.pakalpojumi')->with('success', 'Pakalpojums added successfully!');
    }
}

