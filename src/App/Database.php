<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Handles database connection using PDO.
 */
class Database
{
    /**
     * Database constructor.
     *
     * @param string $host The database host.
     * @param string $database The database name.
     * @param string $user The database user.
     * @param string $password The database password.
     */
    public function __construct(
        private string|int $host,
        private string $database,
        private string $user,
        private string $password
    ) {
    }

    /**
     * Creates and returns a PDO connection to the database.
     *
     * @return PDO The PDO database connection.
     */
    public function getConnection(): PDO
    {
        // Data Source Name (DSN) for connecting to the MySQL database
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8";

        // Create a new PDO instance for database connection
        return new PDO($dsn, $this->user, $this->password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
        ));
    }
}
