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

    public function store(Request $request, $user_id)
    {
        $array = $request->all();
        $array['user_id'] = $user_id;
        $product = Product::create($array);
        return $this->success(compact('product'), 'Yor product has been returned');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return $this->success(compact('product'), 'Your product has been updated');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return $this->success('', 'Your product has been deleted');
    }

}
