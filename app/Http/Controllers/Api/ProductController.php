<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

class ProductController extends ApiController
{
    private $type = 'products';

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
        $this->es_put($product);

        return $this->success(compact('product'), 'Yor product has been returned');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        $this->es_put($product);

        return $this->success(compact('product'), 'Your product has been updated');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        $params = [
            'index' => env('DB_DATABASE'),
            'type' => $this->type,
            'id' => $id
        ];

        $client = ClientBuilder::create()->build();
        $client->delete($params);

        return $this->success('', 'Your product has been deleted');
    }

    public function search(Request $request)
    {
//        dd($request->q);
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => env('DB_DATABASE'),
            'type' => $this->type,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => [
                            'name',
                            'size'
                        ],
//                        'query' => '*' . $request->q . '*'
                        'query' => 'ggf'
                    ]
                ]
            ]
        ];
        $r = $client->search($params);
        dd($r);
//        return
    }

    private function es_put($product)
    {
        $arr = $product->toArray();
        unset($arr['id']);

        $params = [
            'index' => env('DB_DATABASE'),
            'type' => $this->type,
            'id' => $product->id,
            'body' => $arr
        ];

        $client = ClientBuilder::create()->build();
        $client->index($params);
    }
}
