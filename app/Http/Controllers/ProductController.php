<?php
    
namespace App\Http\Controllers;
    
use App\Models\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(): View
   {
    
    $products = Product::with('category', 'variations')->get();
    // 'products.index' enna view file-lekku data pass cheyyunnu
    return view('products.index', compact('products'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $categories = Category::all(); // Database-ile ella categories-um edukku
        return view('products.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
   {
    $validated = $request->validate([
        'product_name' => 'required|max:255',
        'category_id'     => 'required|exists:categories,id',
        'price'        => 'required|numeric',
        'stock'        => 'required|integer',
        'productImage' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'variants'     => 'required|array', // ensure variants is an array
        'variants.*.type' => 'required',
        'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Variation image validation
        'variants.*.sku' => 'required|unique:product_variations,sku',
    ]);

    $imagePath = null; 

    if ($request->hasFile('productImage')) {
        // storing the uploaded image 
        $imagePath = $request->file('productImage')->store('products', 'public');
    }

    $mainProduct = \App\Models\Product::create([
        'product_name' => $request->product_name,
        'category_id'  => $request->category_id,
        'price'        => $request->price,
        'stock'        => $request->stock,
        'image'        => $imagePath,
    ]);

    if ($request->has('variants') && $mainProduct) {
        foreach ($request->variants as $key => $variantData) {

        $variantImagePath = null;

        if ($request->hasFile("variants.$key.image")) {
            $variantImagePath = $request->file("variants.$key.image")->store('variants', 'public');
        }
        
            \App\Models\ProductVariation::create([
                'product_id' => $mainProduct->id,
                'type' => $variantData['type'],
                'color' => $variantData['color'] ?? null,
                'size' => $variantData['size'] ?? null,
                'variant' => $variantData['variant'] ?? null,
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
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product): View
    {
        $product = Product::with(['category', 'variations'])->findOrFail($product->id);
        $isClothing = ($product->category->category_name ?? '') === 'Clothings';

        return view('products.show', compact('product', 'isClothing'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product): View
    {
        $categories = \App\Models\Category::all(); 
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
    $validated = $request->validate([
        'product_name' => 'required|max:255',
        'category_id'     => 'required|exists:categories,id',
        'price'        => 'required|numeric',
        'stock'        => 'required|integer',
        'productImage' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    if ($request->hasFile('productImage')) {
        // Pazhaya image delete cheyyanam ennundenkil ivide cheyyaam
        
        $path = $request->file('productImage')->store('products', 'public');
        $validated['image'] = $path;
    }

    $product->update($validated);

    return redirect()->route('products.index')
                     ->with('success', 'Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
    
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}