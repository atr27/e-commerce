<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand', 'product_images')->get();
        $category = Category::get();
        $brand = Brand::get();

        return Inertia::render('Admin/Product/Index', compact('products', 'category', 'brand'));
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->title = $request->title;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        if($request->hasFile('product_images')) {
            $imageProduct = $request->file('product_images');
            foreach ($imageProduct as $image) {
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move('product_images', $uniqueName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image'=> 'product_images/' . $uniqueName
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product Created');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->title;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->hasFile('product_images')) {
            $imageProduct = $request->file('product_images');
            foreach ($imageProduct as $image) {
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move('product_images', $uniqueName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image'=> 'product_images/' . $uniqueName
                ]);
            }
        }

        $product->update();

        return redirect()->back()->with('success', 'Product Updated');
    }

    public function destroyImage($id)
    {
        $image = ProductImage::where('id', $id);
        $image->delete();
        return redirect()->back()->with('success', 'Image Deleted');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted');
    }
}
