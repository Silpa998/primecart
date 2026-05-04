<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class ExploreProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('Explore-more.index', compact('products', 'categories'));  

    }

    public function addToCartAjax(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->product_name, // DB column 'product_name' aayirikkaam, check it!
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image ? $product->image : 'placeholder.jpg'
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'cartCount' => count($cart), // Unique items count
            'totalQuantity' => array_sum(array_column($cart, 'quantity')), // Total quantity count
            'message' => 'Product added to cart successfully!'
        ]);
    }

    // ExploreProductsController.php

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
    
        return view('products.show', compact('product'));
    }
}