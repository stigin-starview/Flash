<?php

declare(strict_types=1);

namespace learnspace\flash\System;

use PDO;

class DatabaseConnection
{
    private static DatabaseConnection|null $instance = null;
    private PDO $pdo;

    private function __construct()
    {
//        $Config = require __DIR__ . '/../../Config/database.php';
//        $dsn = "mysql:host={$Config['host']};port={$Config['port']};dbname={$Config['dbname']};charset={$Config['charset']}";
//        try {
//            $this->pdo = new PDO($dsn, $Config['username'], $Config['password']);
//            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        } catch (PDOException $e) {
//            die('Database connection failed: ' . $e->getMessage());
//        }
        // Get database connection details from environment variables
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        // Create a PDO connection
        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Return PDO instance for database operations.
    public function getPDO()
    {
        return $this->pdo;
    }
}
