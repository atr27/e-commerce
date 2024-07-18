<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();

        return Inertia::render('Admin/Brands/Index', ['brands' => $brands]);
    }

    public function store(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Brand Created');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->update();

        return redirect()->back()->with('success', 'Brand Updated');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->back()->with('success', 'Brand Deleted');
    }
}
