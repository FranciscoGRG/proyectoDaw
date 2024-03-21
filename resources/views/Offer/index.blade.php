@extends('layouts.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="container">
        <form action="http://localhost/proyectoDaw/public/createOffer" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control">

            <label for="descripcion">Descripcion:</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control">

            <label for="fabricante">Fabricante:</label>
            <input type="text" name="fabricante" id="fabricante" class="form-control">

            <label for="talla">Talla:</label>
            <input type="text" name="talla" id="talla" class="form-control">

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" class="form-control">

            {{-- Hay que poner el name de las imagenes como array, [] --}}
            <label for="imagenes">Imágenes:</label>
            <input type="file" name="imagenes[]" id="imagenes[]" multiple class="form-control"> 

            <label for="categoria">Categoría:</label>
            <select name="categoria" id="categoria" class="form-control">
                <option value="opcion1">Hombre</option>
                <option value="opcion2">Mujer</option>
                <option value="opcion3">Opción 3</option>
            </select>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
@endsection
