<?php
namespace App\Http\Controllers;

use App\Models\Pakalpojumi;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display the details of the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function serviceDetails($id)
    {
        $pakalpojums = Pakalpojumi::with(['lokacija', 'profesionali', 'images'])->find($id);

        if (!$pakalpojums) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $professionalImage = $pakalpojums->profesionali
            ? $pakalpojums->profesionali->profileImage()->first()
            : null;

        return response()->json([
            'id' => $pakalpojums->pakalpojuma_id,
            'title' => $pakalpojums->apraksts,
            'description' => $pakalpojums->apraksts,
            'category' => $pakalpojums->kategorijas_nosaukums,
            'price' => $pakalpojums->cena,
            'location' => [
                'address' => $pakalpojums->lokacija ? $pakalpojums->lokacija->adrese : 'No location specified',
                'description' => $pakalpojums->lokacija ? $pakalpojums->lokacija->apraksts : 'No location details'
            ],
            'professional' => [
                'name' => $pakalpojums->profesionali ? $pakalpojums->profesionali->vards_uzvards : 'No professional assigned',
                'email' => $pakalpojums->profesionali ? $pakalpojums->profesionali->epasts : 'No email provided',
                'profileImage' => $professionalImage ? $professionalImage->image_path : 'images/default-profile.png',
            ],
            'images' => $pakalpojums->images->map(function($image) {
                return ['url' => $image->image_path];
            })
        ]);
    }
}
