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
        $codigo = 'POOMSAE-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $numJueces = $data['num_jueces'] ?? 3;
        $stmt = $db->prepare("INSERT INTO torneos (nombre, fecha, ciudad, lugar, descripcion, id_escuela, codigo_acceso, activo, num_jueces) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)");
        $stmt->bind_param('sssssiii',
            $data['nombre'],
            $data['fecha'],
            $data['ciudad'],
            $data['lugar'],
            $data['descripcion'],
            $data['id_escuela'],
            $codigo,
            $numJueces
        );
        return $stmt->execute();
    }

    public static function actualizar(int $id, array $data): bool
    {
        $db = self::db();
        $numJueces = $data['num_jueces'] ?? 3;
        $stmt = $db->prepare("UPDATE torneos SET nombre=?, fecha=?, ciudad=?, lugar=?, descripcion=?, num_jueces=? WHERE idTorneo=? AND id_escuela=?");
        $stmt->bind_param('sssssiii',
            $data['nombre'],
            $data['fecha'],
            $data['ciudad'],
            $data['lugar'],
            $data['descripcion'],
            $numJueces,
            $id, $data['id_escuela']
        );
        return $stmt->execute();
    }

    public static function listarPorEscuela(int $idEscuela): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT idTorneo, nombre, fecha, ciudad, lugar, descripcion, codigo_acceso, activo, estado FROM torneos WHERE id_escuela=? ORDER BY fecha DESC, idTorneo DESC");
        $stmt->bind_param('i', $idEscuela);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function listarInvitados(int $idEscuela): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT t.idTorneo, t.nombre, t.fecha, t.ciudad, t.lugar, t.descripcion, t.codigo_acceso, t.activo, t.estado, e.nombre as creador_nombre, e.siglas as creador_siglas
            FROM torneo_invitaciones ti
            JOIN torneos t ON t.idTorneo = ti.id_torneo
            JOIN escuelas e ON e.id = t.id_escuela
            WHERE ti.id_escuela = ? AND ti.estado = 'aceptada'
            ORDER BY t.fecha DESC, t.idTorneo DESC");
        $stmt->bind_param('i', $idEscuela);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function listarInvitacionesPendientes(int $idEscuela): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT t.idTorneo, t.nombre, t.fecha, t.ciudad, t.codigo_acceso, e.nombre as creador_nombre, e.siglas as creador_siglas
            FROM torneo_invitaciones ti
            JOIN torneos t ON t.idTorneo = ti.id_torneo
            JOIN escuelas e ON e.id = t.id_escuela
            WHERE ti.id_escuela = ? AND ti.estado = 'pendiente'
            ORDER BY t.fecha DESC, t.idTorneo DESC");
        $stmt->bind_param('i', $idEscuela);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function listarParticipantes(int $idTorneo, ?int $idEscuela = null): array
    {
        $db = self::db();
        if ($idEscuela !== null) {
            $stmt = $db->prepare("SELECT p.id, p.nombre, p.apellido, p.grado, p.cinturon, p.sexo, p.edad, p.ciudad, p.categoria, tp.id_categoria
                FROM torneoparticipante tp
                JOIN participantes p ON p.id = tp.idParticipante
                WHERE tp.idTorneo = ? AND p.id_escuela = ?
                ORDER BY p.apellido, p.nombre");
            $stmt->bind_param('ii', $idTorneo, $idEscuela);
        } else {
            $stmt = $db->prepare("SELECT p.id, p.nombre, p.apellido, p.grado, p.cinturon, p.sexo, p.edad, p.ciudad, p.categoria, p.id_escuela, e.nombre as escuela_nombre, e.siglas as escuela_siglas, tp.id_categoria
                FROM torneoparticipante tp
                JOIN participantes p ON p.id = tp.idParticipante
                JOIN escuelas e ON e.id = p.id_escuela
                WHERE tp.idTorneo = ?
                ORDER BY e.nombre, p.apellido, p.nombre");
            $stmt->bind_param('i', $idTorneo);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function agregarParticipante(int $idTorneo, int $idParticipante, ?int $idCategoria = null): bool
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO torneoparticipante (idTorneo, idParticipante, id_categoria) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE id_categoria = VALUES(id_categoria)");
        $stmt->bind_param('iii', $idTorneo, $idParticipante, $idCategoria);
        return $stmt->execute();
    }

    public static function removerParticipante(int $idTorneo, int $idParticipante): bool
    {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM torneoparticipante WHERE idTorneo = ? AND idParticipante = ?");
        $stmt->bind_param('ii', $idTorneo, $idParticipante);
        return $stmt->execute();
    }

    public static function listarJueces(int $idTorneo): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT j.id, j.nombre, j.apellido, j.user, j.ciudad, j.id_escuela, e.nombre as escuela_nombre, e.siglas as escuela_siglas
            FROM torneojueces tj
            JOIN jueces j ON j.id = tj.idJuez
            JOIN escuelas e ON e.id = j.id_escuela
            WHERE tj.idTorneo = ?
            ORDER BY e.nombre, j.apellido, j.nombre");
        $stmt->bind_param('i', $idTorneo);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function agregarJuez(int $idTorneo, int $idJuez): bool
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT IGNORE INTO torneojueces (idTorneo, idJuez) VALUES (?, ?)");
        $stmt->bind_param('ii', $idTorneo, $idJuez);
        return $stmt->execute();
    }

    public static function removerJuez(int $idTorneo, int $idJuez): bool
    {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM torneojueces WHERE idTorneo = ? AND idJuez = ?");
        $stmt->bind_param('ii', $idTorneo, $idJuez);
        return $stmt->execute();
    }

    public static function listarCategorias(int $idTorneo): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT tc.*,
            (SELECT COUNT(*) FROM torneoparticipante tp WHERE tp.id_categoria = tc.id) as total_participantes
            FROM torneo_categorias tc WHERE tc.id_torneo = ? ORDER BY tc.nombre");
        $stmt->bind_param('i', $idTorneo);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function crearCategoria(array $data): bool
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO torneo_categorias (id_torneo, nombre, sexo, edad_min, edad_max, cinturon_min, cinturon_max) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('issiiss',
            $data['id_torneo'], $data['nombre'], $data['sexo'],
            $data['edad_min'], $data['edad_max'],
            $data['cinturon_min'], $data['cinturon_max']
        );
        return $stmt->execute();
    }

    public static function actualizarCategoria(int $id, array $data): bool
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE torneo_categorias SET nombre=?, sexo=?, edad_min=?, edad_max=?, cinturon_min=?, cinturon_max=? WHERE id=? AND id_torneo=?");
        $stmt->bind_param('ssiissii',
            $data['nombre'], $data['sexo'],
            $data['edad_min'], $data['edad_max'],
            $data['cinturon_min'], $data['cinturon_max'],
            $id, $data['id_torneo']
        );
        return $stmt->execute();
    }

    public static function eliminarCategoria(int $id): bool
    {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM torneo_categorias WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function listarParticipantesPorCategoria(int $idTorneo, int $idCategoria, ?int $idEscuela = null): array
    {
        $db = self::db();
        if ($idEscuela !== null) {
            $stmt = $db->prepare("SELECT p.id, p.nombre, p.apellido, p.grado, p.cinturon, p.sexo, p.edad, p.ciudad, p.categoria, p.peso
                FROM torneoparticipante tp
                JOIN participantes p ON p.id = tp.idParticipante
                WHERE tp.idTorneo = ? AND tp.id_categoria = ? AND p.id_escuela = ?
                ORDER BY p.apellido, p.nombre");
            $stmt->bind_param('iii', $idTorneo, $idCategoria, $idEscuela);
        } else {
            $stmt = $db->prepare("SELECT p.id, p.nombre, p.apellido, p.grado, p.cinturon, p.sexo, p.edad, p.ciudad, p.categoria, p.peso, p.id_escuela, e.nombre as escuela_nombre, e.siglas as escuela_siglas
                FROM torneoparticipante tp
                JOIN participantes p ON p.id = tp.idParticipante
                JOIN escuelas e ON e.id = p.id_escuela
                WHERE tp.idTorneo = ? AND tp.id_categoria = ?
                ORDER BY e.nombre, p.apellido, p.nombre");
            $stmt->bind_param('ii', $idTorneo, $idCategoria);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function cambiarEstado(int $idTorneo, int $estado): bool
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE torneos SET estado = ? WHERE idTorneo = ?");
        $stmt->bind_param('ii', $estado, $idTorneo);
        return $stmt->execute();
    }

    public static function listarTorneosPorJuez(int $idJuez): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT t.*, e.nombre as creador_nombre, e.siglas as creador_siglas
            FROM torneojueces tj
            JOIN torneos t ON t.idTorneo = tj.idTorneo
            JOIN escuelas e ON e.id = t.id_escuela
            WHERE tj.idJuez = ?
            ORDER BY t.estado DESC, t.fecha DESC, t.idTorneo DESC");
        $stmt->bind_param('i', $idJuez);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function listarParticipantesParaJuez(int $idTorneo): array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT p.id, p.nombre, p.apellido, p.grado, p.cinturon, p.sexo, p.edad, tp.id_categoria,
            c.nombre as categoria_nombre, c.sexo as categoria_sexo
            FROM torneoparticipante tp
            JOIN participantes p ON p.id = tp.idParticipante
            LEFT JOIN torneo_categorias c ON c.id = tp.id_categoria
            WHERE tp.idTorneo = ?
            ORDER BY c.nombre, p.apellido, p.nombre");
        $stmt->bind_param('i', $idTorneo);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function obtenerPuntaje(int $idTorneo, int $idParticipante, int $idJuez): ?array
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM torneo_puntajes WHERE id_torneo = ? AND id_participante = ? AND id_juez = ?");
        $stmt->bind_param('iii', $idTorneo, $idParticipante, $idJuez);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public static function guardarPuntaje(int $idTorneo, ?int $idCategoria, int $idParticipante, int $idJuez, float $puntaje, float $fuerzaVelocidad = 0, float $ritmoTiempo = 0, float $expresionEnergia = 0): bool
    {
        $db = self::db();
        if ($idCategoria === 0) $idCategoria = null;
        $sql = "INSERT INTO torneo_puntajes (id_torneo, id_categoria, id_participante, id_juez, puntaje, fuerza_velocidad, ritmo_tiempo, expresion_energia)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE puntaje = ?, fuerza_velocidad = ?, ritmo_tiempo = ?, expresion_energia = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iiiddddddd', $idTorneo, $idCategoria, $idParticipante, $idJuez, $puntaje, $fuerzaVelocidad, $ritmoTiempo, $expresionEnergia, $puntaje, $fuerzaVelocidad, $ritmoTiempo, $expresionEnergia);
        return $stmt->execute();
    }

    public static function obtenerPuntajesPromedio(int $idTorneo): array
    {
        $db = self::db();
        $t = self::find($idTorneo);
        $numJueces = (int)($t['num_jueces'] ?? 3);
        $stmt = $db->prepare("SELECT p.id, p.nombre, p.apellido, p.cinturon, p.grado, p.sexo, p.edad,
            tp.id_categoria, c.nombre as categoria_nombre, c.sexo as categoria_sexo,
            GROUP_CONCAT(COALESCE(tp2.puntaje,0) ORDER BY tp2.id ASC SEPARATOR ',') as puntajes_list,
            GROUP_CONCAT(COALESCE(tp2.fuerza_velocidad,0) ORDER BY tp2.id ASC SEPARATOR ',') as fuerza_list,
            GROUP_CONCAT(COALESCE(tp2.ritmo_tiempo,0) ORDER BY tp2.id ASC SEPARATOR ',') as ritmo_list,
            GROUP_CONCAT(COALESCE(tp2.expresion_energia,0) ORDER BY tp2.id ASC SEPARATOR ',') as expresion_list,
            COUNT(tp2.id) as total_puntajes
            FROM torneoparticipante tp
            JOIN participantes p ON p.id = tp.idParticipante
            LEFT JOIN torneo_categorias c ON c.id = tp.id_categoria
            LEFT JOIN torneo_puntajes tp2 ON tp2.id_torneo = tp.idTorneo AND tp2.id_participante = tp.idParticipante
            WHERE tp.idTorneo = ?
            GROUP BY p.id, tp.id_categoria
            ORDER BY c.nombre, p.apellido, p.nombre");
        $stmt->bind_param('i', $idTorneo);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($rows as &$r) {
            $r['promedio_presentacion'] = null;
            $r['promedio_fuerza'] = null;
            $r['promedio_ritmo'] = null;
            $r['promedio_expresion'] = null;
            $r['promedio_total'] = null;
            $r['puntajes_raw'] = [];

            if ($r['puntajes_list'] && $r['puntajes_list'] !== '') {
                $presentacion = array_map('floatval', explode(',', $r['puntajes_list']));
                $fuerza = array_map('floatval', explode(',', $r['fuerza_list']));
                $ritmo = array_map('floatval', explode(',', $r['ritmo_list']));
                $expresion = array_map('floatval', explode(',', $r['expresion_list']));

                // Keep all arrays in sync when sorting by presentation (ascending to drop lowest/highest)
                array_multisort($presentacion, SORT_ASC, $fuerza, $ritmo, $expresion);
                $r['puntajes_raw'] = $presentacion;

                $fnAvg = function($arr) use ($numJueces) {
                    $count = count($arr);
                    if ($count == 0) return null;
                    if ($numJueces <= 3) {
                        return round(array_sum($arr) / $count, 1);
                    }
                    if ($count > 2) {
                        array_shift($arr);
                        array_pop($arr);
                    }
                    return count($arr) > 0 ? round(array_sum($arr) / count($arr), 1) : 0;
                };

                $r['promedio_presentacion'] = $fnAvg($presentacion);
                $r['promedio_fuerza'] = $fnAvg($fuerza);
                $r['promedio_ritmo'] = $fnAvg($ritmo);
                $r['promedio_expresion'] = $fnAvg($expresion);

                $total = 0;
                foreach ([$r['promedio_presentacion'], $r['promedio_fuerza'], $r['promedio_ritmo'], $r['promedio_expresion']] as $v) {
                    if ($v !== null) $total += $v;
                }
                $r['promedio_total'] = round($total, 1);
            }
        }
        unset($r);

        // Sort by category, then by total score descending (highest first)
        usort($rows, function($a, $b) {
            $catCmp = strcasecmp($a['categoria_nombre'] ?? '', $b['categoria_nombre'] ?? '');
            if ($catCmp !== 0) return $catCmp;
            return ($b['promedio_total'] ?? -1) <=> ($a['promedio_total'] ?? -1);
        });

        return $rows;
    }
}
