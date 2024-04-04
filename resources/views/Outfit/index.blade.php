@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="http://localhost/proyectoDaw/public/create.outfit" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="tipo">Tipo:</label><br>
            <input type="text" id="tipo" name="tipo"><br>

            <label for="zapatos">Zapatos:</label><br>
            <input type="text" id="zapatos" name="zapatos"><br>

            <label for="pantalones">Pantalones:</label><br>
            <input type="text" id="pantalones" name="pantalones"><br>

            <label for="camiseta">Camiseta:</label><br>
            <input type="text" id="camiseta" name="camiseta"><br>

            <label for="abrigo">Abrigo:</label><br>
            <input type="text" id="abrigo" name="abrigo"><br>

            <label for="complementos">Complementos:</label><br>
            <textarea id="complementos" name="complementos" rows="4" cols="50"></textarea><br>

            <label for="imagenes">Imágenes:</label><br>
            <input type="file" name="imagenes[]" id="imagenes[]" multiple> <br><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
@endsection

