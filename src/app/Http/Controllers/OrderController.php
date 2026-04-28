<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderAddress;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function purchase($item_id) {
        $user = Auth::user();
        if (!$user->profile) {
            return redirect('/profile/edit');
        }
        $item = Product::find($item_id);
        $address = $user->profile;
        return view('orders.create', compact('item', 'address'));
    }

    public function create(Request $request) {
        $user = Auth::user();
        $item = Product::find($request->product_id);

        if(!$item->is_sold){
            $orderAddress = OrderAddress::create([
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);

            Order::create([
                'user_id' => $user->id,
                'product_id' => $item->id,
                'order_address_id' => $orderAddress->id,
                'payment_method' => $request->payment_method,
                'purchased_price' => $item->price,
                'purchased_at' => now(),
            ]);

            $item->update(['is_sold' => true]);
        }
        return redirect('/');
    }
}
