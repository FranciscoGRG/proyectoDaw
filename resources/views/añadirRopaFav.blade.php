@extends('layouts.app')

@section('content')
    <h1>Añadir Prenda Favorita</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('add.favoriteClothes') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label for="price">Precio:</label>
            <input type="number" id="precio" name="precio" value="{{ old('precio') }}" required>
        </div>
        <div>
            <label for="image">URL de la imagen:</label>
            <input type="text" id="imagen" name="imagen" value="{{ old('imagen') }}" required>
        </div>
        <div>
            <label for="url">URL:</label>
            <input type="text" id="URL" name="URL" value="{{ old('URL') }}" required>
        </div>
        <div>
            <button type="submit">Añadir Prenda Favorita</button>
        </div>
    </form>


    <h1>Eliminar Prenda Favorita</h1>
    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('delete.favoriteClothes') }}" method="POST">
        @csrf
        @method('DELETE')
        <div>
            <label for="id">ID de la prenda a eliminar:</label>
            <input type="number" id="id" name="id" required>
        </div>
        <div>
            <button type="submit">Eliminar Prenda Favorita</button>
        </div>
    </form>
@endsection
