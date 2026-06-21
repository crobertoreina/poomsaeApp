<?php
namespace App\Models;

use App\Core\Model;

class Participante extends Model
{
    protected static string $table = 'participantes';
    protected static string $primaryKey = 'id';

    public static function crear(array $data): bool
    {
        $db = self::db();
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $sexo = $data['sexo'] ?? null;
        $fechaNac = $data['fecha_nacimiento'] ?? null;
        $grado = $data['grado'] ?? null;
        $cinturon = $data['cinturon'] ?? null;
        $idCinturon = $data['id_cinturon'] ?? null;
        $correo = $data['correo'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $ciudad = $data['ciudad'] ?? null;
        $idEscuela = $data['id_escuela'];
        $stmt = $db->prepare("INSERT INTO participantes (nombre, apellido, sexo, fecha_nacimiento, grado, cinturon, id_cinturon, correo, telefono, ciudad, id_escuela) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssisssi',
            $nombre, $apellido, $sexo, $fechaNac,
            $grado, $cinturon, $idCinturon,
            $correo, $telefono, $ciudad, $idEscuela
        );
        return $stmt->execute();
    }
}
