<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cache;

use App\Models\Product;

use App\Models\ProductVariation;

use App\Models\Cart;



class AddToCartController extends Controller

{

    public function cart()

    {

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['product.category', 'variation'])
                ->latest()
                ->get();
        } else {
            $cartItems = session()->get('temp_cart', []);
            $cartItems = array_reverse($cartItems);
        }



    return view('addtocart.cart', compact('cartItems'));

    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::with('category')->findOrFail($productId);
        // fetch category name for logic
        $categoryName = $product->category->category_name ?? $product->category->name;
        $variationId = $request->input('variation_id');
        $color       = $request->input('color');
        $quantity    = (int)$request->input('quantity', 1);
        $displayPrice = $product->price;
        $displayImage = $product->image;

        if ($variationId) {
            $variantData = \App\Models\ProductVariation::find($variationId);
            if ($variantData) {
                $displayPrice = $variantData->price ?? $product->price;
                $displayImage = $variantData->image ?? $product->image;
            }
        }

        // input from blade
        $inputSize    = $request->input('size');
        $inputVariant = $request->input('variant_name');

        if ($categoryName === 'Clothings' && empty($inputSize)) {
            return back()
              ->with('error', 'Please select a size before adding to cart')
                ->withInput();
        }    

        $sizeToStore = ($categoryName === 'Clothings') ? $inputSize : null;

        $variantToStore = ($categoryName === 'Mobile') ? $inputVariant : null;

        if (!Auth::check()) {

            //store cart data in session for non-logged in users
            $cart = session()->get('temp_cart', []);

            // create a unique key for the cart item based on product and variation          
            $cartKey = $productId . '-' . ($variationId ?? '0') . '-' . ($sizeToStore ?? 'none') . '-' . ($color ?? 'none');            

           

            if (isset($cart[$cartKey])) {

                $cart[$cartKey]['quantity'] += $quantity;

            } else {

                $cart[$cartKey] = [

                    "product_id" => (int)$productId,

                    "variant_id" => $variationId,

                    "product_name" => $product->product_name,

                    "quantity" => $quantity,

                    "price" => $displayPrice,

                    "image" => $displayImage,

                    "selected_size" => $sizeToStore,

                    "selected_color" => $color,

                    "selected_variant" => $variantToStore

                ];

           

            }

            session()->put('temp_cart', $cart);

            return back()->with('success', 'Item added to the cart!');        

        }

        // Auth user

        $cartItem = Cart::where('user_id', Auth::id())

                        ->where('product_id', $productId)

                        ->where('product_variation_id', $variationId)

                        ->where('selected_size', $sizeToStore)

                        ->where('selected_color', $color)

                        ->where('selected_variant', $variantToStore)

                        ->first();

        if($cartItem) {

            $cartItem->increment('quantity', $quantity);

        } else {



            // dd($productId);

            Cart::create([

                'user_id' => Auth::id(),

                'product_id' => (int)$productId,

                'product_variation_id' => $variationId,

                'selected_size' => $sizeToStore,

                'selected_color' => $color,

                'selected_variant' => $variantToStore,

                'quantity' => $quantity,

            ]);

        }              

           

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        }

    public function update(Request $request)

{

    // 1. check if user is logged in

    if (Auth::check()) {

        if ($request->id && $request->quantity) {

            //update the quantity of the product in the user's cart in the database

            Cart::where('user_id', Auth::id())

                ->where('product_id', $request->id)

                ->update(['quantity' => $request->quantity]);



            return response()->json(['success' => 'Cart updated successfully']);

        }

    } else {

       // --- GUEST USER SESSION LOGIC ---

        if ($request->id && $request->quantity) {

            $cart = session()->get('temp_cart', []);



            // check if the product exists in the session cart

            if (isset($cart[$request->id])) {

                //update the quantity of the product in the session cart

                $cart[$request->id]['quantity'] = $request->quantity;

               

                // save the updated cart back to session

                session()->put('temp_cart', $cart);



                return response()->json([

                    'success' => 'Guest cart updated successfully',

                    'new_quantity' => $request->quantity

                ]);

            }



            return response()->json(['error' => 'Product not found in cart'], 404);

        }

    }

}



    public function remove($id, $type = 'product')

{

    if (Auth::check()) {



        Cart::where('user_id', Auth::id())

            ->where('id', $id)

            ->delete();

    } else {

       

        $cart = session()->get('temp_cart', []);

        if (isset($cart[$id])) {

            unset($cart[$id]);

            session()->put('temp_cart', $cart);

        }

    }



    return redirect()->back()->with('success', 'Item removed successfully');

}

}