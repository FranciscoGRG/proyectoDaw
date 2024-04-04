@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($outfits as $outfit)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tipos de outfit: {{ $outfit->type }} <button onclick=""> Borrar
                                </button></h5>
                            <p class="card-text"> Zapatos: {{ $outfit->footwear }}</p>
                            <p class="card-text">Pantalones: {{ $outfit->trousers }}</p>
                            <p class="card-text">Camiseta: {{ $outfit->Tshirt }}</p>
                            <p class="card-text">Abrigo: {{ $outfit->coat }}</p>
                            <p cl ass="card-text">Complementos: {{ $outfit->complements }}</p>
                            @if (!empty($outfit->images))
                                @foreach (json_decode($outfit->images) as $image)
                                    <img src="{{ asset($image) }}" class="card-img-top mb-4" alt="Imagen">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
