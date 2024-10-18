<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Other methods...

    /**
     * Store a newly created resource in storage.
     */
    public function index(Request $request): \Illuminate\Database\Eloquent\Collection|array
    {
        $search = $request->input('search');

        $employees = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('department', 'like', '%' . $search . '%')
                    ->orWhere('id', $search);
            })
            ->get();

        return $employees;
    }
    public function show($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Return the product details
        return $product;
    }

    public function store(Request $request)
    {
        // Log request data for debugging
        Log::debug('Request data:', $request->all());

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'department' => 'required'
        ]);

        // Create a new product instance
        $product = new Product($request->all());

        // Set the myhashi attribute
        $product->myhashi = hash('sha256', $product->name . $product->description . $product->department);

        // Save the product
        $product->save();

        // Log the created product for debugging
        Log::debug('Created product:', $product->toArray());

        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Log request data for debugging
        Log::debug('Request data:', $request->all());

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'department' => 'required'
        ]);

        // Update the product attributes
        $product->fill($request->all());

        // Set the myhashi attribute
        $product->myhashi = hash('sha256', $product->name . $product->description . $product->department);

        // Save the updated product
        $product->save();

        // Log the updated product for debugging
        Log::debug('Updated product:', $product->toArray());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Log the product being deleted for debugging
        Log::debug('Deleting product:', $product->toArray());

        // Delete the product
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
