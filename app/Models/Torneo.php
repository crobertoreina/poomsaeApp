<?php
namespace App\Models;

use App\Core\Model;

class Torneo extends Model
{
    protected static string $table = 'torneos';
    protected static string $primaryKey = 'idTorneo';

    public static function crear(array $data): bool
    {
        $db = self::db();
        $nombre = $data['nombre'];
        $fecha = $data['fecha'];
        $ciudad = $data['ciudad'] ?? '';
        $lugar = $data['lugar'] ?? '';
        $descripcion = $data['descripcion'] ?? '';
        $idEscuela = $data['id_escuela'];
        $codigo = 'POOMSAE-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $stmt = $db->prepare("INSERT INTO torneos (nombre, fecha, ciudad, lugar, descripcion, id_escuela, codigo_acceso, activo) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param('sssssis',
            $nombre, $fecha, $ciudad, $lugar,
            $descripcion, $idEscuela, $codigo
        );
        return $stmt->execute();
    }
}
