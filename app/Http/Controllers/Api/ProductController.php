<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index()
    {
        $products = Product::all();
        $products = $products->toArray();
        return $this->success(compact('products'), 'Your products has been returned');
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $array = $request->all();
        $array['user_id'] = auth()->user()->id;
        Product::create($array);
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
        dd($id);
        Product::find($id)->delete();
        return redirect()->route('product.index');
    }

}
