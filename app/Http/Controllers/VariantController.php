<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Variant;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $variants = Variant::all();

        return response()->json(['data' => $variants]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productId)
    {
        // Find the product
        $product = Product::findOrFail($productId);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:variants',
            'additional_cost' => 'required',
            'stock_count' => 'required',
        ]);

        // Create the variant
        $variant = $product->variants()->create([
            'name' => $validatedData['name'],
            'sku' => $validatedData['sku'],
            'additional_cost' => $validatedData['additional_cost'],
            'stock_count' => $validatedData['stock_count'],
        ]);

        return response()->json(['data' => $variant], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($productId,$id)
    {
        $product = Product::findOrFail($productId);

        // Find the variant
        $variant = $product->variants()->findOrFail($id);

        return response()->json(['data' => $variant], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productId, $variantId)
    {
        // Find the product
        $product = Product::findOrFail($productId);

        // Find the variant
        $variant = $product->variants()->findOrFail($variantId);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:variants,sku,' . $variant->id,
            'additional_cost' => 'required',
            'stock_count' => 'required',
        ]);

        // Update the variant
        $variant->update([
            'name' => $validatedData['name'],
            'sku' => $validatedData['sku'],
            'additional_cost' => $validatedData['additional_cost'],
            'stock_count' => $validatedData['stock_count'],
        ]);

        return response()->json(['data' => $variant], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId, $variantId)
    {
        // Find the product
        $product = Product::findOrFail($productId);

        // Find the variant
        $variant = $product->variants()->findOrFail($variantId);

        // Delete the variant
        $variant->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
