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
        $stmt = $db->prepare("INSERT INTO participantes 
            (nombre, apellido, sexo, fecha_nacimiento, edad, peso, estatura, grado, cinturon, id_cinturon, correo, telefono, ciudad, categoria, id_escuela) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssiddssissssi',
            $data['nombre'],
            $data['apellido'],
            $data['sexo'],
            $data['fecha_nacimiento'],
            $data['edad'],
            $data['peso'],
            $data['estatura'],
            $data['grado'],
            $data['cinturon'],
            $data['id_cinturon'],
            $data['correo'],
            $data['telefono'],
            $data['ciudad'],
            $data['categoria'],
            $data['id_escuela']
        );
        return $stmt->execute();
    }

    public static function actualizar(int $id, array $data): bool
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE participantes SET 
            nombre=?, apellido=?, sexo=?, fecha_nacimiento=?, edad=?, peso=?, estatura=?, 
            grado=?, cinturon=?, id_cinturon=?, correo=?, telefono=?, ciudad=?, categoria=?
            WHERE id=? AND id_escuela=?");
        $stmt->bind_param('ssssiddssissssii',
            $data['nombre'],
            $data['apellido'],
            $data['sexo'],
            $data['fecha_nacimiento'],
            $data['edad'],
            $data['peso'],
            $data['estatura'],
            $data['grado'],
            $data['cinturon'],
            $data['id_cinturon'],
            $data['correo'],
            $data['telefono'],
            $data['ciudad'],
            $data['categoria'],
            $id,
            $data['id_escuela']
        );
        return $stmt->execute();
    }

    public static function listarPorEscuela(int $idEscuela): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT id, nombre, apellido, sexo, fecha_nacimiento, edad, peso, estatura, grado, cinturon, correo, ciudad, categoria FROM participantes WHERE id_escuela=? ORDER BY apellido, nombre");
        $stmt->bind_param('i', $idEscuela);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function listarCinturones(): array
    {
        $db = self::db();
        $r = $db->query("SELECT idCinturon, nombre, colorHex FROM cinturon ORDER BY orden");
        return $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
    }
}
