<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ControllerAuth extends Controller
{
    // Manda al usuario a Google
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google nos devuelve acá con ?code=...
    public function callbackGoogle()
    {
        $googleUser = Socialite::driver('google')->user();

        // 1. ¿Ya entró antes con Google?
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // 2. ¿Existe por email? (usuarios de prueba): vinculamos el google_id
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update(['google_id' => $googleUser->getId()]);
            } else {
                // 3. Usuario nuevo: lo registramos
                $user = User::create([
                    'nombre'    => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]);
            }
        }

        Auth::login($user);
        request()->session()->regenerate(); // evita session fixation

        return redirect()->route('listas.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
