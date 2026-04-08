<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeCheckoutController extends Controller
{
    public function create(Request $request, Product $item)
    {
        if ($item->is_sold) {
            return back()->with('error', 'この商品は売り切れです。');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('items.index') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('items.index'),
            'metadata' => [
                'product_id' => $item->id,
                'user_id' => auth()->id(),
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ],
        ]);

        return redirect($session->url);
    }

}