<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    // public function index()
    // {
    //     return view('index');
    // }

    //Esta funcion recibe el nombre del producto, cantidad y precio y redirecciona a la página de Stripe para realizar el pago
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $request->producto,
                        ],
                        'unit_amount' => $request->precio,
                    ],
                    'quantity' => $request->cantidad,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('index'),
            'cancel_url' => route('index'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return view('index');
    }
}
