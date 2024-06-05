@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Actualizar Outfit</h1>

        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('update.outfit') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="outfit_id">ID del Outfit a Eliminar:</label>
            <input type="number" name="outfit_id" id="outfit_id" required>

            <h3>Camiseta</h3>
            <label for="camiseta_nombre">Nombre:</label>
            <input type="text" name="camiseta_nombre" id="camiseta_nombre" value="{{ old('camiseta_nombre') }}"
                ><br>

            <label for="camiseta_precio">Precio:</label>
            <input type="number" step="0.01" name="camiseta_precio" id="camiseta_precio"
                value="{{ old('camiseta_precio') }}" ><br>

            <label for="camiseta_imagen">Imagen:</label>
            <input type="text" name="camiseta_imagen" id="camiseta_imagen" value="{{ old('camiseta_imagen') }}"
                ><br>

            <label for="camiseta_url">URL:</label>
            <input type="url" name="camiseta_url" id="camiseta_url" value="{{ old('camiseta_url') }}" ><br>

            <h3>Pantalón</h3>
            <label for="pantalon_nombre">Nombre:</label>
            <input type="text" name="pantalon_nombre" id="pantalon_nombre" value="{{ old('pantalon_nombre') }}"
                ><br>

            <label for="pantalon_precio">Precio:</label>
            <input type="number" step="0.01" name="pantalon_precio" id="pantalon_precio"
                value="{{ old('pantalon_precio') }}" ><br>

            <label for="pantalon_imagen">Imagen:</label>
            <input type="text" name="pantalon_imagen" id="pantalon_imagen" value="{{ old('pantalon_imagen') }}"
                ><br>

            <label for="pantalon_url">URL:</label>
            <input type="url" name="pantalon_url" id="pantalon_url" value="{{ old('pantalon_url') }}" ><br>

            <h3>Zapatos</h3>
            <label for="zapatos_nombre">Nombre:</label>
            <input type="text" name="zapatos_nombre" id="zapatos_nombre" value="{{ old('zapatos_nombre') }}"
                ><br>

            <label for="zapatos_precio">Precio:</label>
            <input type="number" step="0.01" name="zapatos_precio" id="zapatos_precio"
                value="{{ old('zapatos_precio') }}" ><br>

            <label for="zapatos_imagen">Imagen:</label>
            <input type="text" name="zapatos_imagen" id="zapatos_imagen" value="{{ old('zapatos_imagen') }}"
                ><br>

            <label for="zapatos_url">URL:</label>
            <input type="url" name="zapatos_url" id="zapatos_url" value="{{ old('zapatos_url') }}" ><br>

            <button type="submit">Crear Outfit</button>
        </form>
    </div>

@endsection
