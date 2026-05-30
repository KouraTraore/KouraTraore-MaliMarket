<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

   public function register(Request $request)
{
    $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users',
        'password'  => 'required|string|min:6|confirmed',
        'telephone' => 'nullable|string|max:20',
        'role'      => 'nullable|in:client,vendeur',
    ]);

    $user = User::create([
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'telephone' => $request->telephone,
        'role'      => $request->role ?? 'client',
    ]);

    Auth::login($user);

    // Si vendeur → créer automatiquement sa boutique
    if ($user->role === 'vendeur') {
        \App\Models\Vendor::create([
            'user_id'      => $user->id,
            'nom_boutique' => $user->name . "'s Shop",
            'slug'         => \Illuminate\Support\Str::slug($user->name) . '-' . uniqid(),
            'telephone'    => $user->telephone,
            'ville'        => 'Bamako',
            'statut'       => 'en_attente',
            'commission'   => 10.00,
        ]);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Bienvenue ! Votre boutique a été créée. En attente de validation par l\'admin.');
    }

    return redirect()->route('home');
}
}