<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;


class WishlistController extends Controller
{
    public function toggle(Request $request, $productId) {
        $variationId = $request->input('variation_id'); 

        $wishlist = Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $productId)
                            ->where('product_variation_id', $variationId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete(); 
            return response()->json(['status' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => auth()->id(), 
                'product_id' => $productId,
                'product_variation_id' => $variationId 
            ]); 
            return response()->json(['status' => 'added']);
        }
    }

    public function index() {
        $wishlistItems = Wishlist::where('user_id', auth()->id())
                            ->with(['product', 'variation']) 
                            ->get();
        return view('wishlist.wishlist', compact('wishlistItems'));
    }
    

    public function moveToCart(Request $request, $productId) {
    $variationId = $request->input('variation_id');

    $wishlistItem = Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $productId)
                            ->where('product_variation_id', $variationId)
                            ->first();

    if ($wishlistItem) {
        $product = Product::findOrFail($productId);
        $variation = $wishlistItem->variation;

        $cart = session()->get('cart', []);
        
        // identify different variations of same product with unique key
        $cartKey = $variationId ? $productId . '-' . $variationId : $productId;

        if(isset($cart[$cartKey])){
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "name" => $product->product_name . ($variation ? " ({$variation->variant})" : ""),
                "quantity" => 1,
                "price" => $variation ? $variation->price : $product->price,
                "image" => ($variation && $variation->image) ? $variation->image : $product->image,
                "variation_id" => $variationId
            ];
        }

        session()->put('cart', $cart);
        $wishlistItem->delete(); 
        
        return redirect()->route('cart')->with('success', 'Product moved to cart!');
    }
    return redirect()->back()->with('error', 'Item not found.');
}
    
public function show($id) {
    $product = Product::findOrFail($id);
    $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                        ->where('product_id', $id)
                                        ->exists();

    return view('wishlist.show', compact('product', 'isWishlisted'));
}
}