<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $pdoInstance = null;

    public static function connect(): ?PDO
    {
        try {
            if (!static::$pdoInstance) {
                static::$pdoInstance = new PDO("mysql:host=database;dbname=tdd_query", "root", "root", [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
            }

            return static::$pdoInstance;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }
}