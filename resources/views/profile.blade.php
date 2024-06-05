@extends('layouts.app')

@section('content')
    <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Otros campos del perfil -->

        <div>
            <label for="profile_image">Imagen de Perfil</label>
            <input type="file" name="profile_image" id="profile_image">
        </div>

        <button type="submit">Actualizar Perfil</button>
    </form>


    @if (Auth::user()->profile_image)
        <img src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" alt="Imagen de Perfil">
    @endif
@endsection
