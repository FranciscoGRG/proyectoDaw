@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($offers as $offer)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $offer->name }}</h5>
                            <p class="card-text">{{ $offer->description }}</p>
                            <p class="card-text">{{ $offer->manufacturer }}</p>
                            <p class="card-text">{{ $offer->size }}</p>
                            <p class="card-text">{{ $offer->price }}</p>
                            <p cl   ass="card-text">{{ $offer->category }}</p>
                            @if (!empty($offer->images))
                                @foreach (json_decode($offer->images) as $image)
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
