@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('checkout') }}" method="POST">
            <label>Producto: Movil wapo wapo</label>
            <input type="hidden" name="producto" id="producto" value="jaifon">

            <br>

            <label>Precio: 2000€</label>
            <input type="hidden" name="precio" id="precio" value="2000">

            <br>

            <label>Cantidad: 12</label>
            <input type="hidden" name="cantidad" id="cantidad" value="12">

            <br>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit">Checkout</button>
        </form>
    </div>
@endsection
