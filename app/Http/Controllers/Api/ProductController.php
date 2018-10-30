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
        return $this->success(compact('products'));
    }

    public function store(Request $request)
    {
        $array = $request->all();
        $array['user_id'] = auth()->id();
        $product = Product::create($array);
        $this->esPut($product);

        return $this->success(compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        $this->esPut($product);

        return $this->success(compact('product'));
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

        return $this->success();
    }

    public function search(Request $request)
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => env('DB_DATABASE'),
            'type' => $this->type,
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            ['regexp' => ['name' => '.*' . $request->q . '.*']],
                            ['regexp' => ['size' => '.*' . $request->q . '.*']],
                        ]
                    ]
                ]
            ]
        ];

        $r = $client->search($params);
        $products = $this->compactSearchResult($r);

        return $this->success($products);
    }

    private function compactSearchResult($r)
    {
        $es_products = $r['hits']['hits'];
        $products = [];
        if (!empty($es_products)) {
            foreach ($es_products as $es_product)
            {
                $arr = $es_product['_source'];
                $arr['id'] = $es_product['_id'];
                $products[] = $arr;
            }
        }
        return compact('products');
    }


//    private function setMapping()
//    {
//        $params = [
//            'index' => 'sweden_postal_codes',
//            'body' => [
//                'mappings' => [
//                    'codes' => [
//                        'properties' => [
//                            'location' => [
//                                'type' => 'geo_point'
//                            ],
//                            'city' => [
//                                'type' => 'string'
//                            ]
//                        ]
//                    ]
//                ]
//            ]
//
//        ];
//
//        $client = ClientBuilder::create()->build();
//        $response = $client->indices()->create($params);
//    }

    private function esPut($product)
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
