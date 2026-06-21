<?php
namespace App\Models;

use App\Core\Model;

class Escuela extends Model
{
    protected static string $table = 'escuelas';
    protected static string $primaryKey = 'id';

    public static function findByCorreo(string $correo): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM escuelas WHERE correo = ?");
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function findByUser(string $user): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM escuelas WHERE user = ?");
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function crear(array $data): array|false
    {
        $db = self::db();
        $passHash = password_hash($data['pass'], PASSWORD_DEFAULT);
        $nombre = $data['nombre'];
        $siglas = $data['siglas'] ?? '';
        $fechaFundacion = $data['fecha_fundacion'] ?? null;
        $instructorNombre = $data['instructor_nombre'] ?? '';
        $instructorGrado = $data['instructor_grado'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $pais = $data['pais'] ?? '';
        $ciudad = $data['ciudad'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $correo = $data['correo'];
        $user = $data['user'] ?? $correo;

        $stmt = $db->prepare("INSERT INTO escuelas (nombre, siglas, fecha_fundacion, instructor_nombre, instructor_grado, telefono, pais, ciudad, direccion, correo, user, pass, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param('ssssssssssss',
            $nombre, $siglas, $fechaFundacion,
            $instructorNombre, $instructorGrado,
            $telefono, $pais, $ciudad, $direccion,
            $correo, $user, $passHash
        );

        if ($stmt->execute()) {
            return ['id' => $db->insert_id];
        }
        return false;
    }

    public static function actualizar(int $id, array $data): bool
    {
        $db = self::db();
        $sets = [];
        $types = '';
        $params = [];
        foreach ($data as $col => $val) {
            $sets[] = "`$col` = ?";
            $types .= 's';
            $params[] = $val;
        }
        $types .= 'i';
        $params[] = $id;
        $sql = "UPDATE escuelas SET " . implode(', ', $sets) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }
}
