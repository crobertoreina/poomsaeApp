<?php
namespace App\Core;

class Model
{
    protected static string $table = '';
    protected static string $primaryKey = 'id';

    protected static function db(): \mysqli
    {
        return Database::getInstance()->getConnection();
    }

    public static function find(int $id): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function all(): array
    {
        $db = self::db();
        $result = $db->query("SELECT * FROM " . static::$table . " ORDER BY " . static::$primaryKey . " DESC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function where(string $column, $value): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $column = ?");
        $stmt->bind_param('s', $value);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function delete(int $id): bool
    {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
