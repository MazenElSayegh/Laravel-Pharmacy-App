<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{
    public function index() {
        return view('payments.index');
    }

    public function checkout() {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
       
        $line_items = [
            [
                'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'T-shirt',
                ],
                'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ],
            [
                'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'T-shirt',
                ],
                'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ],
        ];

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [$line_items],
            'mode' => 'payment',
            'success_url' => route('payments.success', [], true),
            'cancel_url' => route('payments.cancel', [], true),
        ]);

        return redirect($checkout_session->url);
    }

    public function success() {
        return view("payments.success");
    }

    public function cancel() {
        return view("payments.cancel");
    }
}
