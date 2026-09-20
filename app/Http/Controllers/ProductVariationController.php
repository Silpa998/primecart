<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductVariationController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['variations', 'category'])->get();
        
        return view('Product-Variations.index', compact('products'));
    }

    public function create(Request $request)
    {
        $productId = $request->query('product_id');
        
        $product = Product::findOrFail($productId);

        return view('product-variations.create', compact('product'));
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'type'       => 'required|string',
        'color'      => 'nullable|string',
        'size'       => 'nullable|string',
        'variant'    => 'nullable|string',
        'price'      => 'required|numeric|min:0',
        'stock'      => 'required|integer|min:0',
        'sku'        => 'nullable|string|unique:product_variations,sku',
        'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('variations', 'public');
        $data['image'] = $path;
    }

    ProductVariation::create($data);

    return redirect()->route('product-variations.index')->with('success', 'Variation added successfully!');
}
}
