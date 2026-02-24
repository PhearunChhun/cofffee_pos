<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageUpload;
class ProductController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'sizes')->latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('products.form', compact('categories', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'sizes' => 'array',
            'sizes.*' => 'exists:sizes,id',
            'size_prices' => 'array',
            'size_prices.*' => 'numeric|min:0',
        ]);

        $data = $request->only(['name', 'category_id', 'base_price', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        $product = Product::create($data);

        if ($request->sizes) {
            $syncData = [];
            foreach ($request->sizes as $sizeId) {
                $syncData[$sizeId] = [
                    'price' => $request->size_prices[$sizeId] ?? 0
                ];
            }
            $product->sizes()->sync($syncData);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('products.form', compact('product', 'categories', 'sizes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'sizes' => 'array',
            'sizes.*' => 'exists:sizes,id',
            'size_prices' => 'array',
            'size_prices.*' => 'numeric|min:0',
        ]);

        $data = $request->only(['name', 'category_id', 'base_price', 'description']);

        if ($request->hasFile('image')) {

            // Delete old image safely (using trait)
            $this->deleteImage($product->image);

            // Upload new image
            $data['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        $product->update($data);

        if ($request->sizes) {
            $syncData = [];
            foreach ($request->sizes as $sizeId) {
                $syncData[$sizeId] = [
                    'price' => $request->size_prices[$sizeId] ?? 0
                ];
            }
            $product->sizes()->sync($syncData);
        } else {
            $product->sizes()->detach();
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->deleteImage($product->image);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
