<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Pieteikumi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Image as PakalpojumsImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

use Illuminate\Support\Facades\Validator;


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
        // Basic validation
        $request->validate([
            'nosaukums' => 'required|string|max:255',
            'apraksts' => 'required|string|max:200',
            'kategorijas_nosaukums' => 'required|string|max:50',
            'cena' => 'required|numeric|min:0',
            'iela_majasnr' => 'required|string|max:255',
            'pilseta' => 'required|string|max:255',
        ]);

        $adrese = $request->input('iela_majasnr') . ', ' . $request->input('pilseta');

        // Log request data
        Log::info('Request data:', $request->all());

        // Custom image validation
        $images = $request->file('images');
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/webp'];
        $maxSize = 2048 * 1024; // 2MB

        foreach ($images as $image) {
            $mimeType = $image->getMimeType();
            $size = $image->getSize();

            if (!in_array($mimeType, $allowedMimes) || $size > $maxSize) {
                Log::error('Validation failed for image:', ['image' => $image->getClientOriginalName(), 'mimeType' => $mimeType, 'size' => $size]);
                return redirect()->back()->withErrors(['images' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg and not exceed 2MB.'])->withInput();
            }
        }

        // Create the service
        $pakalpojums = Pakalpojumi::create([
            'nosaukums' => $request->nosaukums,
            'apraksts' => $request->apraksts,
            'kategorijas_nosaukums' => $request->kategorijas_nosaukums,
            'cena' => $request->cena,
            'adrese' => $adrese,
            'profesionalis_id' => Auth::user()->id,
        ]);

        // Log the creation of the service
        Log::info('Pakalpojums created:', $pakalpojums->toArray());

        // Store the images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $pakalpojums->images()->create(['image_path' => $path]);
                // Log each image upload
                Log::info('Image uploaded:', ['path' => $path]);
            }
        }

        // Log successful creation of service
        Log::info('Service created successfully:', ['service' => $pakalpojums]);

        return redirect()->route('profesionalis.pakalpojumi')->with('success', 'Pakalpojums added successfully!');
    }
}