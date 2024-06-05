<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            // Borra la imagen anterior si existe
            if ($user->profile_image) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }

            // Sube la nueva imagen
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_images', $filename);

            // Actualiza el campo profile_image del usuario
            $user->profile_image = $filename;
        }

        // Guarda otros campos del perfil
        // $user->other_field = $request->input('other_field');

        $user->save();

        return redirect()->route('index.profile')->with('success', 'Perfil actualizado exitosamente.');
    }
}
