<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //all products
        $products = \App\Models\Product::orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            // price
            'price' => 'required|integer',
            // stock
            'stock' => 'required|integer',
            // category
            'category' => 'required|in:food,drink,snack',
            // image
            'image' => 'required|image|mimes:png,jpg,jpeg',


        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $product = \App\Models\Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category' => $request->category,
            'image' => $filename,
            'is_best_seller' => $request->is_best_seller
        ]);
        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dibuat',
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat produk'
            ], 400);

            ;

        }

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
