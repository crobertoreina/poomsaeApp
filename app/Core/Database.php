<?php
namespace App\Core;

class Database
{
    private static ?Database $instance = null;
    private \mysqli $connection;

    private function __construct()
    {
        $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->connection->set_charset('utf8');
    }

    public static function getInstance(): self
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    public function getConnection(): \mysqli
    {
        return $this->connection;
    }
}
