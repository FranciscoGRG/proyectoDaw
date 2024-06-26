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
            'profile_image' => 'nullable|string', // Validate that profile_image is a base64 string
        ]);

        $user = Auth::user();

        if ($request->input('profile_image')) {
            // Borra la imagen anterior si existe
            if ($user->profile_image) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }

            // Decodifica la imagen base64 y guarda el archivo
            $imageData = $request->input('profile_image');
            $filename = time() . '.png';
            $imagePath = 'public/profile_images/' . $filename;

            Storage::put($imagePath, base64_decode($imageData));

            // Actualiza el campo profile_image del usuario
            $user->profile_image = $filename;
        }

        // Guarda otros campos del perfil
        // $user->other_field = $request->input('other_field');

        $user->save();

        return response()->json(['profileImage' => $user->profile_image]);
    }

    public function getProfileImga()
    {
        $user = Auth::user();
        return response()->json(['profileImage' => $user->profile_image]);
    }
}
