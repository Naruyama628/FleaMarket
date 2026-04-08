<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Product;


class AddressController extends Controller
{
    //
    public function edit($item_id) {
        return view('addresses.edit', compact('item_id'));
    }

    public function create (Request $request) {
        $item = Product::find($request->item_id);
        $address = (object) [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        return view('orders.create', compact('item', 'address'));
    }
}
