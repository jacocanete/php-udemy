<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Viewer;

/**
 * Controller for the Home page.
 */
class Home
{
    /**
     * Home constructor.
     *
     * @param Viewer $viewer The view renderer dependency.
     */
    public function __construct(private Viewer $viewer)
    {
    }

    /**
     * Displays the home page by rendering header, main content, and footer.
     *
     * @return void
     */
    public function index()
    {
        echo $this->viewer->render(
            'shared/header.php'
        );
        echo $this->viewer->render(
            'Home/index.php'
        );
        echo $this->viewer->render(
            'shared/footer.php'
        );
    }
}
