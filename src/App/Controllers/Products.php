<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

/**
 * Controller for handling product-related pages and actions.
 */
class Products
{
    /**
     * Products constructor.
     *
     * @param Viewer $viewer The view renderer dependency.
     * @param Product $model The product model dependency.
     */
    public function __construct(private Viewer $viewer, private Product $model)
    {
    }

    /**
     * Displays the list of products.
     *
     * @return void
     */
    public function index()
    {
        $products = $this->model->getData();

        echo $this->viewer->render(
            'shared/header.php'
        );
        echo $this->viewer->render(
            'Products/index.php',
            array(
                'products' => $products,
            )
        );
        echo $this->viewer->render(
            'shared/footer.php'
        );
    }

    /**
     * Displays a single product by ID.
     *
     * @param string $id The product ID.
     * @return void
     */
    public function show(string $id)
    {
        echo $this->viewer->render(
            'shared/header.php'
        );
        echo $this->viewer->render(
            'Products/show.php',
            array(
            'id' => $id,
            )
        );
        echo $this->viewer->render(
            'shared/footer.php'
        );
    }

    /**
     * Displays a paginated product page.
     *
     * @param string $title The product title.
     * @param string $id The product ID.
     * @param string $page The page number.
     * @return void
     */
    public function showPage(string $title, string $id, string $page)
    {
        echo $title, ' ', $id, ' ', $page;
    }
}
