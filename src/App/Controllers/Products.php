<?php

namespace App\Controllers;

use App\Models\Product;

class Products
{
    /**
     * Retrieves product data and renders the products index view.
     */
    public function index()
    {
        $model = new Product();

        $products = $model->getData();

        require 'src/views/products_index.php';
    }

    /**
     * Displays details for a specific product identified by its ID.
     *
     * Outputs the provided product ID and includes the product detail view.
     *
     * @param string $id The unique identifier of the product to display.
     */
    public function show(string $id)
    {
        var_dump($id);
        require 'src/views/products_show.php';
    }

    /**
     * Outputs the provided title, id, and page as a single space-separated string.
     *
     * @param string $title The title to display.
     * @param string $id The identifier to display.
     * @param string $page The page value to display.
     */
    public function showPage(string $title, string $id, string $page)
    {
        echo $title, ' ', $id, ' ', $page;
    }
}
