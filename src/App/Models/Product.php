<?php

namespace App\Models;

use PDO;

class Product
{
    public function getData(): array
    {
        // Data Source Name (DSN) for connecting to the MySQL database
        $dsn = 'mysql:host=localhost;dbname=product_db;charset=utf8';

        // Create a new PDO instance for database connection
        $pdo = new PDO($dsn, 'product_db_user', 'secret', array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
        ));

        // Fetch all products from the product table
        $stmt = $pdo->query('SELECT * FROM product');

        // Fetch all products as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
