<?php

namespace App\Http\Controllers;


use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.create', compact('product'));
    }

    public function update(Request $request, $id)
    {
        Product::find($id)->update($request->all());
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {

        Product::find($id)->delete();
        return redirect()->route('product.index');
    }
}
