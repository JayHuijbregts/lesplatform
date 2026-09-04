<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $configPath = dirname(__DIR__, 2)
            . '/config/config.php';

        if (!file_exists($configPath)) {
            throw new RuntimeException(
                'Databaseconfiguratie ontbreekt.'
            );
        }

        $config = require $configPath;
        $database = $config['database'];

        $dsn =
            "mysql:host={$database['host']};" .
            "port={$database['port']};" .
            "dbname={$database['name']};" .
            "charset={$database['charset']}";

        try {
            self::$connection = new PDO(
                $dsn,
                $database['username'],
                $database['password'],
                [
                    PDO::ATTR_ERRMODE =>
                        PDO::ERRMODE_EXCEPTION,

                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                        PDO::FETCH_ASSOC,

                    PDO::ATTR_EMULATE_PREPARES =>
                        false
                ]
            );
        } catch (PDOException) {
            throw new RuntimeException(
                'Er kon geen verbinding met de database worden gemaakt.'
            );
        }

        return self::$connection;
    }
}