<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakalpojumi;
use Illuminate\Support\Facades\Log;

class FiltrationController extends Controller
{
    public function filter(Request $request)
    {
        try {
            $filters = $request->all();
            Log::info('Filter request received', ['filters' => $filters]);
            
            $query = Pakalpojumi::query();

            if ($request->has('savedServices') && $request->savedServices === 'on') {
                Log::info('Filtering by saved services');
                $query->whereHas('favorites', function($query) {
                    $query->where('user_id', auth()->id());
                });
            }

            if ($request->filled('priceMin')) {
                Log::info('Filtering by min price', ['priceMin' => $request->priceMin]);
                $query->where('cena', '>=', $request->priceMin);
            }

            if ($request->filled('priceMax')) {
                Log::info('Filtering by max price', ['priceMax' => $request->priceMax]);
                $query->where('cena', '<=', $request->priceMax);
            }

            if ($request->filled('category')) {
                Log::info('Filtering by category', ['category' => $request->category]);
                $query->where('kategorijas_nosaukums', $request->category);
            }

            if ($request->filled('city')) {
                Log::info('Filtering by city', ['city' => $request->city]);
                $query->whereHas('lokacija', function($query) use ($request) {
                    $query->where('adrese', 'like', '%' . $request->city . '%');
                });
            }

            if ($request->filled('keyword')) {
                Log::info('Filtering by keyword', ['keyword' => $request->keyword]);
                $query->where('apraksts', 'like', '%' . $request->keyword . '%');
            }

            $pakalpojumi = $query->with('lokacija')->get();
            Log::info('Filtered pakalpojumi', ['pakalpojumi' => $pakalpojumi]);

            return response()->json(['pakalpojumi' => $pakalpojumi]);
        } catch (\Exception $e) {
            Log::error('Error filtering services', ['exception' => $e]);
            return response()->json(['error' => 'An error occurred while filtering services.'], 500);
        }
    }
}
