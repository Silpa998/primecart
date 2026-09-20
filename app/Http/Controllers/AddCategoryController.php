<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use App\Models\Variation;

class AddCategoryController extends Controller
{
    public function create()
    {
        $all_variations = Variation::all();
        return view('category.add-category', compact('all_variations'));
    }

    public function index()
    {
        $categories = Category::all();

        // preload all variations to avoid N+1 query problem
        $variations = Variation::pluck('variation_name', 'id');

        foreach ($categories as $category) {

            // stored ids
            $variationIds = $category->available_variations ?? [];

            // ids -> names convert
            $category->variation_names = collect($variationIds)->map(function ($id) use ($variations) {
                return $variations[$id] ?? 'Unknown';
            });
       }
        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:1,0',
            'available_variations' => 'nullable|array',
            'available_variations.*' => 'exists:variations,id', 
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status,
            'available_variations' => $request->available_variations,

        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $all_variations = Variation::all();
        return view('category.edit', compact('category', 'all_variations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'status' => 'required|in:1,0',
            'available_variations' => 'nullable|array',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status,
            'available_variations' => $request->available_variations,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }
    public function destroy($id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();
    
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}