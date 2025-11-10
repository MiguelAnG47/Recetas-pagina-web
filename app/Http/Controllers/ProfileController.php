<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User; // ✅ Importa el modelo

class ProfileController extends Controller
{
    /** Muestra la vista del perfil del usuario. */
    public function index(): View
    {
        return view('perfil.index', [
            'user' => Auth::user(),
        ]);
    }

    /** Actualiza la información del perfil del usuario. */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'apellido' => ['nullable', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'edad'     => ['nullable', 'integer', 'min:1', 'max:120'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->nombre   = $validated['nombre'];
        $user->apellido = $validated['apellido'] ?? $user->apellido;
        $user->email    = $validated['email'];
        $user->edad     = $validated['edad'] ?? $user->edad;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save(); // ✅ Ya no debería marcar error
        return Redirect::route('perfil.index')->with('status', 'profile-updated');
    }

    /** Elimina la cuenta del usuario actual. */
    public function destroy(Request $request): RedirectResponse
    {
        // Si tu formulario NO pide contraseña, elimina este bloque
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        Auth::logout();
        $user->delete(); // ✅ Ya no marca error

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deleted');
    }
}
