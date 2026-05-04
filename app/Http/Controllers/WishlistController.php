<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;


class WishlistController extends Controller
{
    public function toggle(Request $request, $productId) {
        $wishlist = Wishlist::where('user_id', auth()->id())
                    ->where('product_id', $productId)->first();
        if ($wishlist) {
            $wishlist->delete(); 
            return response()->json(['status' => 'removed']);
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $productId]); 
            return response()->json(['status' => 'added']);
        }
    }

    public function index() {
        $wishlistItems = Wishlist::where('user_id', auth()->id())
                             ->with('product') 
                             ->get();
        return view('wishlist.wishlist', compact('wishlistItems'));
    }
    
    
    public function moveToCart($productId) {
    // 1. Find the wishlist item for the logged-in user
    $wishlistItem = Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $productId)
                            ->first();

    if ($wishlistItem) {
        // 2. Fetch product details
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        // 3. Update quantity if already in cart, else add new entry
        if(isset($cart[$productId])){
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->product_name, // Ensure this matches your DB column
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        // 4. Update the session
        session()->put('cart', $cart);

        // 5. Remove from wishlist and redirect to cart page
        $wishlistItem->delete(); 
        
        return redirect()->route('cart')->with('success', 'Product moved to cart!');
    }

    return redirect()->back()->with('error', 'Item not found in wishlist.');
}

public function show($id) {
    $product = Product::findOrFail($id);
    $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                        ->where('product_id', $id)
                                        ->exists();

    return view('wishlist.show', compact('product', 'isWishlisted'));
}
}