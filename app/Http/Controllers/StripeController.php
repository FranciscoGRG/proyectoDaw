<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
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




//Esta es la funcion actualizada para cobrar una comision del 3% al vendedor. Este necesita una cuenta de Stripe para poder recibir el dinero de la venta
    // public function checkout(Request $request)
    // {
    //     Stripe::setApiKey(config('stripe.sk'));

    //     // Calcula el monto de la comisión (3% del precio total)
    //     $comision = $request->precio * $request->cantidad * 0.03;

    //     // Calcula el monto a transferir al vendedor (precio total - comisión)
    //     $monto_vendedor = ($request->precio * $request->cantidad) - $comision;

    //     // Crea la sesión de pago en Stripe
    //     $session = Session::create([
    //         'payment_method_types' => ['card'],
    //         'line_items' => [
    //             [
    //                 'price_data' => [
    //                     'currency' => 'eur',
    //                     'product_data' => [
    //                         'name' => $request->producto,
    //                     ],
    //                     'unit_amount' => $request->precio,
    //                 ],
    //                 'quantity' => $request->cantidad,
    //             ],
    //         ],
    //         'payment_intent_data' => [
    //             'application_fee_amount' => (int) $comision, // Comisión
    //             'transfer_data' => [
    //                 'destination' => '{{ VENDEDOR_ACCOUNT_ID }}', // ID de la cuenta del vendedor
    //                 'amount' => (int) $monto_vendedor, // Monto para el vendedor
    //             ],
    //         ],
    //         'mode' => 'payment',
    //         'success_url' => route('success'),
    //         'cancel_url' => route('index'),
    //     ]);

    //     return redirect()->away($session->url);
    // }