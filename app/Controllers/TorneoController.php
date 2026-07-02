<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Torneo;
use App\Models\InvitacionTorneo;

class TorneoController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $escuela = \App\Models\Escuela::find($id);
        $torneos = Torneo::listarPorEscuela($id);
        $invitados = Torneo::listarInvitados($id);
        $pendientes = Torneo::listarInvitacionesPendientes($id);
        $this->view('torneos/index', [
            'escuela' => $escuela,
            'torneos' => $torneos,
            'torneosInvitados' => $invitados,
            'invitacionesPendientes' => $pendientes,
        ]);
    }

    public function listar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $this->json(Torneo::listarPorEscuela($id));
    }

    public function obtener(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $this->json($t);
    }

    public function guardar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $data = [
            'nombre' => trim($this->getParam('nombre', '')),
            'fecha' => $this->getParam('fecha'),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'lugar' => trim($this->getParam('lugar', '')),
            'descripcion' => trim($this->getParam('descripcion', '')),
            'num_jueces' => (int)$this->getParam('num_jueces', '3'),
            'id_escuela' => $id,
        ];
        if (empty($data['nombre']) || empty($data['fecha'])) {
            $this->json(['success' => false, 'message' => 'Nombre y fecha obligatorios.']);
            return;
        }
        $ok = Torneo::crear($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Torneo creado.' : 'Error al crear.']);
    }

    public function actualizar(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $data = [
            'nombre' => trim($this->getParam('nombre', '')),
            'fecha' => $this->getParam('fecha'),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'lugar' => trim($this->getParam('lugar', '')),
            'descripcion' => trim($this->getParam('descripcion', '')),
            'num_jueces' => (int)$this->getParam('num_jueces', '3'),
            'id_escuela' => $escuelaId,
        ];
        if (empty($data['nombre']) || empty($data['fecha'])) {
            $this->json(['success' => false, 'message' => 'Nombre y fecha obligatorios.']);
            return;
        }
        $ok = Torneo::actualizar($tid, $data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Torneo actualizado.' : 'Error al actualizar.']);
    }

    public function eliminar(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $ok = Torneo::delete($tid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Eliminado.' : 'Error al eliminar.']);
    }

    public function unirse(): void
    {
        $this->requireAuth();
        $codigo = trim($this->getParam('codigo', ''));
        $escuelaId = $_SESSION['escuela_id'];
        if (empty($codigo)) {
            $this->json(['success' => false, 'message' => 'Código requerido.']);
            return;
        }
        $result = InvitacionTorneo::aceptarPorCodigo($codigo, $escuelaId);
        $this->json($result ?? ['success' => false, 'message' => 'Código inválido.']);
    }

    public function detalle(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $esCreador = $t['id_escuela'] == $escuelaId;
        if (!$esCreador) {
            $db = \App\Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT 1 FROM torneo_invitaciones WHERE id_torneo = ? AND id_escuela = ? AND estado = 'aceptada'");
            $stmt->bind_param('ii', $tid, $escuelaId);
            $stmt->execute();
            if (!$stmt->get_result()->fetch_row()) {
                $this->json(['success' => false, 'message' => 'No tienes acceso a este torneo.']);
                return;
            }
        }
        $participantes = Torneo::listarParticipantes($tid, $esCreador ? null : $escuelaId);
        $jueces = Torneo::listarJueces($tid);
        $categorias = Torneo::listarCategorias($tid);
        $this->json([
            'success' => true,
            'torneo' => $t,
            'esCreador' => $esCreador,
            'participantes' => $participantes,
            'total' => count($participantes),
            'jueces' => $jueces,
            'categorias' => $categorias,
            'total_categorias' => count($categorias),
        ]);
    }

    public function participantes(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t) {
            $this->json([]);
            return;
        }
        $esCreador = $t['id_escuela'] == $escuelaId;
        $this->json(Torneo::listarParticipantes($tid, $esCreador ? null : $escuelaId));
    }

    public function puntajes(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $this->json(['success' => true, 'puntajes' => Torneo::obtenerPuntajesPromedio($tid)]);
    }

    public function scoreboard(): void
    {
        $tid = $this->getInt('id');
        $t = Torneo::find($tid);
        if (!$t) {
            $this->view('scoreboard/index', ['error' => 'Torneo no encontrado.']);
            return;
        }
        $puntajes = Torneo::obtenerPuntajesPromedio($tid);
        $this->view('scoreboard/index', [
            'torneo' => $t,
            'puntajes' => $puntajes,
        ]);
    }

    public function agregarParticipante(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id_torneo');
        $pid = $this->getInt('id_participante');
        $cid = $this->getInt('id_categoria');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t) {
            $this->json(['success' => false, 'message' => 'Torneo no encontrado.']);
            return;
        }
        $acceso = false;
        if ($t['id_escuela'] == $escuelaId) {
            $acceso = true;
        } else {
            $db = \App\Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT 1 FROM torneo_invitaciones WHERE id_torneo = ? AND id_escuela = ? AND estado = 'aceptada'");
            $stmt->bind_param('ii', $tid, $escuelaId);
            $stmt->execute();
            $acceso = (bool)$stmt->get_result()->fetch_row();
        }
        if (!$acceso) {
            $this->json(['success' => false, 'message' => 'No tienes acceso.']);
            return;
        }
        $p = \App\Models\Participante::find($pid);
        if (!$p || $p['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'Participante no válido.']);
            return;
        }
        $ok = Torneo::agregarParticipante($tid, $pid, $cid ?: null);
        $this->json(['success' => $ok, 'message' => $ok ? 'Participante agregado a la categoría.' : 'Ya está registrado en este torneo.']);
    }

    public function removerParticipante(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id_torneo');
        $pid = $this->getInt('id_participante');
        $escuelaId = $_SESSION['escuela_id'];
        $p = \App\Models\Participante::find($pid);
        if (!$p || $p['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'Participante no válido.']);
            return;
        }
        $ok = Torneo::removerParticipante($tid, $pid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Participante removido.' : 'Error al remover.']);
    }

    public function invitarEscuela(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id_torneo');
        $idEscuelaInvitada = $this->getInt('id_escuela');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        if ($idEscuelaInvitada == $escuelaId) {
            $this->json(['success' => false, 'message' => 'No puedes invitarte a ti mismo.']);
            return;
        }
        $ok = InvitacionTorneo::invitar($tid, $idEscuelaInvitada);
        $this->json(['success' => $ok, 'message' => $ok ? 'Invitación enviada.' : 'Ya está invitada.']);
    }

    public function categorias(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t) { $this->json([]); return; }
        $esCreador = $t['id_escuela'] == $escuelaId;
        $categorias = Torneo::listarCategorias($tid);
        $result = [];
        foreach ($categorias as $c) {
            $participantes = Torneo::listarParticipantesPorCategoria($tid, $c['id'], $esCreador ? null : $escuelaId);
            $c['participantes'] = $participantes;
            $c['total_participantes'] = count($participantes);
            $result[] = $c;
        }
        $this->json($result);
    }

    public function guardarCategoria(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id_torneo');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'Solo el creador puede gestionar categorías.']);
            return;
        }
        $data = [
            'id_torneo' => $tid,
            'nombre' => trim($this->getParam('nombre', '')),
            'sexo' => $this->getParam('sexo', 'X'),
            'edad_min' => $this->getInt('edad_min'),
            'edad_max' => $this->getInt('edad_max'),
            'cinturon_min' => trim($this->getParam('cinturon_min', '')),
            'cinturon_max' => trim($this->getParam('cinturon_max', '')),
        ];
        if (empty($data['nombre'])) {
            $this->json(['success' => false, 'message' => 'Nombre de categoría requerido.']);
            return;
        }
        $ok = Torneo::crearCategoria($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Categoría creada.' : 'Error al crear.']);
    }

    public function actualizarCategoria(): void
    {
        $this->requireAuth();
        $cid = $this->getInt('id');
        $tid = $this->getInt('id_torneo');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'Solo el creador puede gestionar categorías.']);
            return;
        }
        $data = [
            'id_torneo' => $tid,
            'nombre' => trim($this->getParam('nombre', '')),
            'sexo' => $this->getParam('sexo', 'X'),
            'edad_min' => $this->getInt('edad_min'),
            'edad_max' => $this->getInt('edad_max'),
            'cinturon_min' => trim($this->getParam('cinturon_min', '')),
            'cinturon_max' => trim($this->getParam('cinturon_max', '')),
        ];
        $ok = Torneo::actualizarCategoria($cid, $data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Categoría actualizada.' : 'Error al actualizar.']);
    }

    public function eliminarCategoria(): void
    {
        $this->requireAuth();
        $cid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $db = \App\Core\Database::getInstance()->getConnection();
        $r = $db->query("SELECT tc.id_torneo, t.id_escuela FROM torneo_categorias tc JOIN torneos t ON t.idTorneo = tc.id_torneo WHERE tc.id = $cid");
        $cat = $r ? $r->fetch_assoc() : null;
        if (!$cat || $cat['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $ok = Torneo::eliminarCategoria($cid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Categoría eliminada.' : 'Error al eliminar.']);
    }

    public function iniciar(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        if ($t['estado'] != 0) {
            $this->json(['success' => false, 'message' => 'El torneo ya fue iniciado.']);
            return;
        }
        $ok = Torneo::cambiarEstado($tid, 1);
        $this->json(['success' => $ok, 'message' => $ok ? 'Torneo iniciado.' : 'Error al iniciar.']);
    }

    public function finalizar(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        if ($t['estado'] != 1) {
            $this->json(['success' => false, 'message' => 'El torneo no está en curso.']);
            return;
        }
        $ok = Torneo::cambiarEstado($tid, 2);
        $this->json(['success' => $ok, 'message' => $ok ? 'Torneo finalizado.' : 'Error al finalizar.']);
    }

    public function toggleEstado(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        if ($t['estado'] == 2) {
            $this->json(['success' => false, 'message' => 'El torneo ya finalizó.']);
            return;
        }
        $nuevoEstado = $t['estado'] == 0 ? 1 : 0;
        // If enabling, check date
        if ($nuevoEstado == 1 && !empty($t['fecha'])) {
            $hoy = new \DateTime();
            $fechaTorneo = \DateTime::createFromFormat('Y-m-d', $t['fecha']);
            if ($fechaTorneo && $fechaTorneo < $hoy->setTime(0, 0, 0)) {
                $this->json(['success' => false, 'message' => 'No puedes activar un torneo cuya fecha ya pasó.']);
                return;
            }
        }
        $ok = Torneo::cambiarEstado($tid, $nuevoEstado);
        $this->json(['success' => $ok, 'message' => $ok ? 'Estado actualizado.' : 'Error al actualizar.']);
    }

    public function listarEscuelas(): void
    {
        $this->requireAuth();
        $escuelaId = $_SESSION['escuela_id'];
        $db = \App\Core\Database::getInstance()->getConnection();
        $result = $db->query("SELECT id, nombre, siglas, ciudad FROM escuelas WHERE id != $escuelaId AND estado = 1 ORDER BY nombre");
        $this->json($result ? $result->fetch_all(MYSQLI_ASSOC) : []);
    }

    public function jueces(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $this->json(Torneo::listarJueces($tid));
    }

    public function agregarJuez(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id_torneo');
        $jid = $this->getInt('id_juez');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'Solo el creador puede asignar jueces.']);
            return;
        }
        $j = \App\Models\Juez::find($jid);
        if (!$j) {
            $this->json(['success' => false, 'message' => 'Juez no válido.']);
            return;
        }
        $ok = Torneo::agregarJuez($tid, $jid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Juez asignado al torneo.' : 'Ya está asignado.']);
    }

    public function removerJuez(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id_torneo');
        $jid = $this->getInt('id_juez');
        $escuelaId = $_SESSION['escuela_id'];
        $t = Torneo::find($tid);
        if (!$t || $t['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'Solo el creador puede remover jueces.']);
            return;
        }
        $ok = Torneo::removerJuez($tid, $jid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Juez removido.' : 'Error al remover.']);
    }

    public function salir(): void
    {
        $this->requireAuth();
        $tid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM torneo_invitaciones WHERE id_torneo = ? AND id_escuela = ?");
        $stmt->bind_param('ii', $tid, $escuelaId);
        $ok = $stmt->execute();
        $this->json(['success' => $ok, 'message' => $ok ? 'Has salido del torneo.' : 'Error al salir.']);
    }
}
