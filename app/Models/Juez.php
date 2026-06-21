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
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $telefono = $data['telefono'] ?? '';
        $ciudad = $data['ciudad'] ?? '';
        $user = $data['user'];
        $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
        $level = 2;
        $idEscuela = $data['id_escuela'];
        $stmt = $db->prepare("INSERT INTO jueces (nombre, apellido, telefono, ciudad, user, pass, level, id_escuela) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssiii',
            $nombre, $apellido, $telefono, $ciudad,
            $user, $pass, $level, $idEscuela
        );
        return $stmt->execute();
    }
}
