<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use App\Database;

/**
 * Model for handling product data and database interactions.
 */
class Product
{
    /**
     * Product constructor.
     *
     * @param Database $database The database connection dependency.
     */
    public function __construct(private Database $database)
    {
    }

    /**
     * Retrieves all product data from the database.
     *
     * @return array The list of products as associative arrays.
     */
    public function getData(): array
    {
        $pdo = $this->database->getConnection();

        // Fetch all products from the product table
        $stmt = $pdo->query('SELECT * FROM product');

        // Fetch all products as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
