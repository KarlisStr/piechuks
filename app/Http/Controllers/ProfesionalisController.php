<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use App\Models\Pieteikumi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfesionalisController extends Controller
{
    public function index()
    {
        return redirect()->route('profesionalis.pieteikumi');
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
            'apraksts' => 'required|string|max:200',
            'kategorijas_nosaukums' => 'required|string|max:50',
            'cena' => 'required|string|max:20',
            'lokacijas_id' => 'required|integer',
        ]);

        Pakalpojumi::create([
            'apraksts' => $request->apraksts,
            'kategorijas_nosaukums' => $request->kategorijas_nosaukums,
            'cena' => $request->cena,
            'lokacijas_id' => $request->lokacijas_id,
            'profesionalis_id' => Auth::user()->id,
        ]);

        return redirect()->route('profesionalis.pakalpojumi')->with('success', 'Pakalpojums added successfully!');
    }
}
