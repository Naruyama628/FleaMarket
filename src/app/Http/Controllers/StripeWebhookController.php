<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $secret = config('services.stripe.webhook_secret');

        try {
            if (app()->environment('testing')) {
                $event = json_decode($payload);
            } else {
                $event = Webhook::constructEvent($payload, $sigHeader, $secret);
            }
        } catch (\UnexpectedValueException|SignatureVerificationException $e) {
            return response('Invalid payload', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            DB::transaction(function () use ($session) {
                $product = Product::lockForUpdate()->find($session->metadata->product_id);

                if (! $product || $product->is_sold) {
                    return;
                }

                $orderAddress = OrderAddress::create([
                    'postal_code' => $session->metadata->postal_code,
                    'address' => $session->metadata->address,
                    'building' => $session->metadata->building,
                    ]);

                Order::create([
                    'user_id' => $session->metadata->user_id,
                    'product_id' => $product->id,
                    'order_address_id' => $orderAddress->id,
                    'payment_method' => $session->metadata->payment_method,
                    'purchased_at' => now(),
                    'purchased_price' => $session->amount_total,
                ]);

                $product->update([
                    'is_sold' => true,
                ]);
            });
        }

        return response('ok', 200);
    }
}