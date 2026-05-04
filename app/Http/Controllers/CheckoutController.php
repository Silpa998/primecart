<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;


class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
    }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('addtocart.checkout', compact('cartItems', 'total'));
    }

    public function singleProductCheckout(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->query('quantity', 1);

        return view('addtocart.single-checkout', compact('product', 'quantity'));
    }
}
