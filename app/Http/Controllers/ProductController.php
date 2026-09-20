<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'variations'])->get();
        
        return view('products.index', compact('products'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // 1. Fetching all categories and all variations mapped by ID
        $categories = Category::where('status', '1')->get();
        $allVariations = Variation::where('status', 'active')->get()->keyBy('id');

        // 2. Mapping each category's available_variations to get name and slug
        foreach ($categories as $category) {
            $mappedVariations = [];
            
            if (is_array($category->available_variations)) {
                foreach ($category->available_variations as $varId) {
                    if (isset($allVariations[$varId])) {
                        $mappedVariations[] = [
                            'name' => $allVariations[$varId]->variation_name,
                            'slug' => $allVariations[$varId]->slug
                        ];
                    }
                }
            }
            
            // Assigning the mapped variations to a dynamic property
            $category->mapped_variations = $mappedVariations;
        }

        return view('products.create', compact('categories'));
    }
   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_name'     => 'required|max:255',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric',
            'stock'            => 'required|integer',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants'         => 'required|array', 
            'variants.*.type'  => 'nullable',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'variants.*.sku'   => 'required|unique:product_variations,sku',
        ]);

        
        $imagePath = null; 
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $mainProduct = Product::create([
            'product_name' => $request->product_name,
            'category_id'  => $request->category_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'image'        => $imagePath,
        ]);

        if ($request->has('variants') && $mainProduct) {
            foreach ($request->input('variants') as $key => $variantData) {
                
                $variantImagePath = null;
                if ($request->hasFile("variants.$key.image")) {
                    $variantImagePath = $request->file("variants.$key.image")->store('variants', 'public');
                }

                $typeValue = null;
                if (isset($variantData['type'])) {
                    $typeValue = is_array($variantData['type']) ? implode(',', $variantData['type']) : $variantData['type'];
                }
                
                ProductVariation::create([
                    'product_id' => $mainProduct->id,
                    'type'       => $typeValue, 
                    'color'      => $variantData['color'] ?? null,
                    'size'       => $variantData['size'] ?? null,
                    'variant'    => $variantData['variant'] ?? null,
                    'image'      => $variantImagePath,
                    'price'      => $variantData['price'] ?? $mainProduct->price,
                    'stock'      => $variantData['stock'] ?? $mainProduct->stock,
                    'sku'        => $variantData['sku'] ?? null,
                ]);
            }
        }
        
        return redirect()->route('products.index')
            ->with('success', 'Product and variations added successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product = Product::with(['category', 'variations'])->findOrFail($product->id);
        $isClothing = ($product->category->category_name ?? '') === 'Clothings';

        return view('products.show', compact('product', 'isClothing'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all(); 
        
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'category_id'  => 'required|exists:categories,id',
            'price'        => 'required|numeric',
            'stock'        => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Validation rules for variations
            'variants'         => 'nullable|array',
            'variants.*.id'    => 'required|exists:product_variations,id',
            'variants.*.sku'   => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.color' => 'nullable|string|max:255',
            'variants.*.size'  => 'nullable|string|max:255',
            'variants.*.variant'=> 'nullable|string|max:255',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Extra dynamic SKU validation to avoid conflicting with other items while ignoring itself
    if ($request->has('variants')) {
        foreach ($request->variants as $index => $variantData) {
            $request->validate([
                "variants.{$index}.sku" => "unique:product_variations,sku,{$variantData['id']}",
            ]);
        }
    }

        if ($request->hasFile('image')) {
            // Optional: You can delete the old image here if needed
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        // 5. Loop and process existing variation updates
    if ($request->has('variants')) {
        foreach ($request->variants as $index => $variantData) {
            
            // Look up variation model belonging to this specific product context
            $variation = ProductVariation::where('id', $variantData['id'])
                                          ->where('product_id', $product->id)
                                          ->first();

            if ($variation) {
                // Initialize payload
                $updatePayload = [
                    'sku'     => $variantData['sku'],
                    'price'   => $variantData['price'],
                    'stock'   => $variantData['stock'],
                    'color'   => $variantData['color'] ?? null,
                    'size'    => $variantData['size'] ?? null,
                    'variant' => $variantData['variant'] ?? null,
                ];

                // Handle individual file mutations inside this item block iteration
                if ($request->hasFile("variants.{$index}.image")) {
                    // Optional: delete old image file from storage
                    // if ($variation->image) \Storage::disk('public')->delete($variation->image);

                    $variantImagePath = $request->file("variants.{$index}.image")->store('variants', 'public');
                    $updatePayload['image'] = $variantImagePath;
                }

                $variation->update($updatePayload);
            }
        }
    }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
    
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}