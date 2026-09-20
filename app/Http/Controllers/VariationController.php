<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Models\Variation;   

class VariationController extends Controller
{
    public function index() {
        $variations = Variation::all(); 
        return view('variations.index', compact('variations'));
    }

    public function create() {
        return view('variations.create');
    }

    public function store(Request $request)
    {
        // 1. Validate
        $validated = $request->validate([
            'variation_name' => 'required|string|max:255|unique:variations,variation_name',
            'slug'           => 'nullable|string|max:255',
            'status'         => 'required|in:active,inactive',
        ]);

        // 2. Generate slug (fallback if JS didn't send it)
        $slug = Str::slug($validated['variation_name']);

        // 3. Handle duplicate slugs  e.g. color, color-1, color-2
        $originalSlug = $slug;
        $count = 1;
        while (Variation::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // 4. Create the record
        Variation::create([
            'variation_name' => $validated['variation_name'],
            'slug'           => $slug,
            'status'         => $validated['status'],
        ]);

        // 5. Redirect with success message
        return redirect()->route('variations.index')
                         ->with('success', 'Variation created successfully.');
    }

    public function edit($id)
    {
        $variation = Variation::findOrFail($id);
        return view('variations.edit', compact('variation'));
    }

    public function update(Request $request, $id)
    {
        $variation = Variation::findOrFail($id);
        // Validate the input
        $validated = $request->validate([
            'variation_name' => 'required|string|max:255|unique:variations,variation_name,' . $variation->id,
            'status'         => 'required|in:active,inactive',
        ]);

        // generate new slug based on the updated name
        $slug = Str::slug($validated['variation_name']);
        $originalSlug = $slug;
        $count = 1;
        
        // check for duplicates excluding the current record
        while (Variation::where('slug', $slug)->where('id', '!=', $variation->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $variation->update([
            'variation_name' => $validated['variation_name'],
            'slug'           => $slug,
            'status'         => $validated['status'],
        ]);

        return redirect()->route('variations.index')
                         ->with('success', 'Variation updated successfully.');
    }

    public function destroy($id)
    {
        $variation = Variation::findOrFail($id);
        $variation->delete();

        return redirect()->route('variations.index')
                         ->with('success', 'Variation deleted successfully.');
    }
}
