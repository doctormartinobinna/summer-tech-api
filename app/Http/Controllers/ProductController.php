<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Products fetched successfully',
            'data' => ProductResource::collection($products)
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'image' => $imagePath,
            'is_active' => $validatedData['is_active'] ?? true,
        ]);
        $product->load('category');
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201);
    }


    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product fetched successfully',
            'data' => new ProductResource($product)
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }
        
        $validatedData = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => ['required','string','max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'image' => $imagePath,
            'is_active' => $validatedData['is_active'] ?? true,
        ]);

        $product->load('category');

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ]);
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function bulkStore(Request $request)
    {
        $validatedData = $request->validate([
            'products' => 'required|array|min:1',

            'products.*.category_id' => 'required|integer|exists:categories,id',
            'products.*.name' => 'required|string|max:255',
            'products.*.slug' => 'required|string|max:255|distinct|unique:products,slug',
            'products.*.description' => 'nullable|string',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.image' => 'nullable|string|max:255',
            'products.*.is_active' => 'nullable|boolean',
        ]);

        $products = collect($validatedData['products'])->map(function ($product) {
            return [
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'] ?? null,
                'price' => $product['price'],
                'image' => $product['image'] ?? null,
                'is_active' => $product['is_active'] ?? true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::transaction(function () use ($products) {
            Product::insert($products);
        });

        $createdProducts = Product::with('category')
            ->whereIn('slug', collect($products)->pluck('slug'))
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Products created successfully',
            'count' => count($products),
            'data' => ProductResource::collection($createdProducts),
        ], 201);
    }
}