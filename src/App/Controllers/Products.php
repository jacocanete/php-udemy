<?php

namespace App\Controllers;

use App\Models\Product;

class Products
{
    public function index()
    {
        $model = new Product();

        $products = $model->getData();

        require 'src/views/products_index.php';
    }

    public function show()
    {
        require 'src/views/products_show.php';
    }
}
