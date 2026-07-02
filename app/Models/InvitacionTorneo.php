<?php
namespace App\Models;

use App\Core\Model;

class InvitacionTorneo extends Model
{
    protected static string $table = 'torneo_invitaciones';
    protected static string $primaryKey = 'id';

    public static function invitar(int $idTorneo, int $idEscuela): bool
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT IGNORE INTO torneo_invitaciones (id_torneo, id_escuela, estado) VALUES (?, ?, 'pendiente')");
        $stmt->bind_param('ii', $idTorneo, $idEscuela);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    public static function aceptarPorCodigo(string $codigo, int $idEscuela): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT idTorneo, id_escuela FROM torneos WHERE codigo_acceso = ? AND activo = 1");
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $torneo = $stmt->get_result()->fetch_assoc();
        if (!$torneo) return null;

        if ($torneo['id_escuela'] == $idEscuela) return ['error' => 'No puedes unirte a tu propio torneo.'];

        $inv = $db->prepare("INSERT IGNORE INTO torneo_invitaciones (id_torneo, id_escuela, estado) VALUES (?, ?, 'aceptada')");
        $inv->bind_param('ii', $torneo['idTorneo'], $idEscuela);
        $inv->execute();
        if ($inv->affected_rows === 0) {
            $chk = $db->prepare("SELECT estado FROM torneo_invitaciones WHERE id_torneo = ? AND id_escuela = ?");
            $chk->bind_param('ii', $torneo['idTorneo'], $idEscuela);
            $chk->execute();
            $existing = $chk->get_result()->fetch_assoc();
            return ['error' => 'Ya ' . ($existing['estado'] === 'aceptada' ? 'estás unido' : 'tienes una invitación pendiente') . ' a este torneo.'];
        }
        return ['success' => true, 'torneo' => $torneo];
    }

    public static function listarInvitados(int $idTorneo): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT ti.id, ti.estado, ti.created_at, e.id as escuela_id, e.nombre as escuela_nombre, e.siglas as escuela_siglas FROM torneo_invitaciones ti JOIN escuelas e ON e.id = ti.id_escuela WHERE ti.id_torneo = ?");
        $stmt->bind_param('i', $idTorneo);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
