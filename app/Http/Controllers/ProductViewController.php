<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


class ProductViewController extends Controller
{
    public function index()
    {
        $client           = new Client();
        $url              = 'http://127.0.0.1:8000/api/login';
        $data['email']    = 'ahad@gmail.com';
        $data['password'] = '123456';

        $request = $client->post($url, [
            'form_params' => $data,
        ]);

        $response = $request->getBody();
        $info     = json_decode($response, true);
        $token    = $info['data']['token'];
        
        $product_url = 'http://127.0.0.1:8000/api/products';
        $product_request = $client->get($product_url, [
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ]);

        $product_response = json_decode($product_request->getBody(), true);

        $products = $product_response['data'];
        // return $products;
        return view('product', compact('products'));

    }
}
