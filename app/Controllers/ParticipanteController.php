<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Participante;

class ParticipanteController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $escuela = \App\Models\Escuela::find($id);
        $participantes = Participante::listarPorEscuela($id);
        $cinturones = array_values(array_filter(
            Participante::listarCinturones(),
            fn($c) => !str_contains($c['nombre'], 'Dan')
        ));
        $this->view('participantes/index', [
            'escuela' => $escuela,
            'participantes' => $participantes,
            'cinturones' => $cinturones,
            'categorias' => ['Infantil','Juvenil','Senior','Master'],
            'grados' => ['10mo KUP','9no KUP','8vo KUP','7mo KUP','6to KUP','5to KUP','4to KUP','3er KUP','2do KUP','1er KUP','1er DAN','2do DAN','3er DAN','4to DAN','5to DAN','6to DAN','7mo DAN','8vo DAN','9no DAN'],
        ]);
    }

    public function listar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $this->json(Participante::listarPorEscuela($id));
    }

    public function obtener(): void
    {
        $this->requireAuth();
        $pid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $p = Participante::find($pid);
        if (!$p || $p['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $this->json($p);
    }

    public function guardar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $data = $this->buildData($id);
        if (empty($data['nombre']) || empty($data['apellido'])) {
            $this->json(['success' => false, 'message' => 'Nombre y apellido obligatorios.']);
            return;
        }
        $ok = Participante::crear($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Participante agregado.' : 'Error al agregar.']);
    }

    public function actualizar(): void
    {
        $this->requireAuth();
        $pid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $p = Participante::find($pid);
        if (!$p || $p['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $data = $this->buildData($escuelaId);
        if (empty($data['nombre']) || empty($data['apellido'])) {
            $this->json(['success' => false, 'message' => 'Nombre y apellido obligatorios.']);
            return;
        }
        $ok = Participante::actualizar($pid, $data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Participante actualizado.' : 'Error al actualizar.']);
    }

    public function eliminar(): void
    {
        $this->requireAuth();
        $pid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $p = Participante::find($pid);
        if (!$p || $p['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $ok = Participante::delete($pid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Eliminado.' : 'Error al eliminar.']);
    }

    private function buildData(int $idEscuela): array
    {
        return [
            'nombre' => trim($this->getParam('nombre', '')),
            'apellido' => trim($this->getParam('apellido', '')),
            'sexo' => $this->getParam('sexo'),
            'fecha_nacimiento' => $this->getParam('fecha_nacimiento'),
            'edad' => $this->getInt('edad'),
            'peso' => $this->getParam('peso'),
            'estatura' => $this->getParam('estatura'),
            'grado' => trim($this->getParam('grado', '')),
            'cinturon' => trim($this->getParam('cinturon', '')),
            'id_cinturon' => $this->getInt('id_cinturon'),
            'correo' => trim($this->getParam('correo', '')),
            'telefono' => trim($this->getParam('telefono', '')),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'categoria' => trim($this->getParam('categoria', '')),
            'id_escuela' => $idEscuela,
        ];
    }
}
