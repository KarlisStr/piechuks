<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profesionali;
use App\Models\Klienti;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_professional' => 'nullable|boolean', // Validate the checkbox
        ]);

        Log::info('Validated data:', $validated);

        // Create the User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_professional' => $request->boolean('is_professional') ? 1 : 0, // Store as integer
        ]);

        Log::info('User created:', $user->toArray());

        // Check if the user is registering as a professional
        if ($request->boolean('is_professional')) {
            // Create a Professional
            $professional = Profesionali::create([
                'profesionalis_id' => $user->id, // Assuming user ID is used as the professional ID
                'vards_uzvards' => $user->name,
                'epasts' => $user->email,
                'telefons' => null,
                'bankas_konts' => null,
                'statuss' => 0,
                'user_id' => $user->id,
                'admin_id' => null,
            ]);

            Log::info('Professional created:', $professional->toArray());
        } else {
            // Create a Client
            $client = Klienti::create([
                'klients_id' => $user->id, // Assuming user ID is used as the client ID
                'vards_uzvards' => $user->name,
                'epasts' => $user->email,
                'telefons' => null,
                'bankas_konts' => null,
                'statuss' => 0,
                'user_id' => $user->id, // Assign the user ID
            ]);

            Log::info('Client created:', $client->toArray());
        }

        return redirect()->back()->with('success', 'Reģistrācija veiksmīga, lūdzu pieslēdzieties.')->with('email', $request->email);
    }
}
