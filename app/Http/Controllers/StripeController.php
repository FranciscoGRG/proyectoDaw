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
<<<<<<< HEAD

    public function prueba()
    {
        $curl = curl_init();


        curl_setopt_array($curl, [
            CURLOPT_URL => "https://real-time-amazon-data.p.rapidapi.com/search?query=Phone&page=1&country=US&category_id=aps",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: real-time-amazon-data.p.rapidapi.com",
                "X-RapidAPI-Key: 5ceb206ccdmsh98b125e3039cf6dp17428fjsn6ccb2d02a6a3"
            ],
        ]);


        $response = curl_exec($curl);
        $err = curl_error($curl);


        curl_close($curl);


        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
=======
>>>>>>> 2151cf5c786dff65ce1a4c2b1277a43a7ce999ae
}
