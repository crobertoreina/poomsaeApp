<?php
namespace App\Models;

use App\Core\Model;

class Juez extends Model
{
    protected static string $table = 'jueces';
    protected static string $primaryKey = 'id';

    public static function crear(array $data): bool
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO jueces (nombre, apellido, telefono, ciudad, user, pass, level, id_escuela) VALUES (?, ?, ?, ?, ?, ?, 2, ?)");
        $passHash = password_hash($data['pass'], PASSWORD_DEFAULT);
        $stmt->bind_param('ssssssi',
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['ciudad'],
            $data['user'],
            $passHash,
            $data['id_escuela']
        );
        return $stmt->execute();
    }

    public static function actualizar(int $id, array $data): bool
    {
        $db = self::db();
        if (!empty($data['pass'])) {
            $stmt = $db->prepare("UPDATE jueces SET nombre=?, apellido=?, telefono=?, ciudad=?, user=?, pass=? WHERE id=? AND id_escuela=?");
            $passHash = password_hash($data['pass'], PASSWORD_DEFAULT);
            $stmt->bind_param('ssssssii',
                $data['nombre'],
                $data['apellido'],
                $data['telefono'],
                $data['ciudad'],
                $data['user'],
                $passHash,
                $id, $data['id_escuela']
            );
        } else {
            $stmt = $db->prepare("UPDATE jueces SET nombre=?, apellido=?, telefono=?, ciudad=?, user=? WHERE id=? AND id_escuela=?");
            $stmt->bind_param('sssssii',
                $data['nombre'],
                $data['apellido'],
                $data['telefono'],
                $data['ciudad'],
                $data['user'],
                $id, $data['id_escuela']
            );
        }
        return $stmt->execute();
    }

    public static function findByUser(string $user): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM jueces WHERE user = ? LIMIT 1");
        $stmt->bind_param('s', $user);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public static function listarPorEscuela(int $idEscuela): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT id, nombre, apellido, user, ciudad FROM jueces WHERE id_escuela=? ORDER BY apellido, nombre");
        $stmt->bind_param('i', $idEscuela);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
