@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>

                    <div class="card-body">
                        <a href="{{ route('index') }}" class="btn btn-primary">Crear oferta</a>
                    </div>

                    <div class="card-body">
                        <a href="{{ route('indexPago') }}" class="btn btn-primary">Pagar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
