<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;


class WishlistController extends Controller
{
    // public function toggle(Request $request, $productId) {
    //     $wishlist = Wishlist::where('user_id', auth()->id())
    //                 ->where('product_id', $productId)->first();
    //     if ($wishlist) {
    //         $wishlist->delete(); 
    //         return response()->json(['status' => 'removed']);
    //     } else {
    //         Wishlist::create(['user_id' => auth()->id(), 'product_id' => $productId]); 
    //         return response()->json(['status' => 'added']);
    //     }
    // }


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
    
//     public function moveToCart($productId) {
//     // 1. Find the wishlist item for the logged-in user
//     $wishlistItem = Wishlist::where('user_id', auth()->id())
//                             ->where('product_id', $productId)
//                             ->first();

//     if ($wishlistItem) {
//         // 2. Fetch product details
//         $product = Product::findOrFail($productId);
//         $cart = session()->get('cart', []);

//         // 3. Update quantity if already in cart, else add new entry
//         if(isset($cart[$productId])){
//             $cart[$productId]['quantity']++;
//         } else {
//             $cart[$productId] = [
//                 "name" => $product->product_name, // Ensure this matches your DB column
//                 "quantity" => 1,
//                 "price" => $product->price,
//                 "image" => $product->image
//             ];
//         }

//         // 4. Update the session
//         session()->put('cart', $cart);

//         // 5. Remove from wishlist and redirect to cart page
//         $wishlistItem->delete(); 
        
//         return redirect()->route('cart')->with('success', 'Product moved to cart!');
//     }

//     return redirect()->back()->with('error', 'Item not found in wishlist.');
// }

public function show($id) {
    $product = Product::findOrFail($id);
    $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                        ->where('product_id', $id)
                                        ->exists();

    return view('wishlist.show', compact('product', 'isWishlisted'));
}
}