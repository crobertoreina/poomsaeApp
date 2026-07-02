<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Juez;

class JuezController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $escuela = \App\Models\Escuela::find($id);
        $jueces = Juez::listarPorEscuela($id);
        $this->view('jueces/index', [
            'escuela' => $escuela,
            'jueces' => $jueces,
        ]);
    }

    public function listar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $this->json(Juez::listarPorEscuela($id));
    }

    public function obtener(): void
    {
        $this->requireAuth();
        $jid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $j = Juez::find($jid);
        if (!$j || $j['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        unset($j['pass'], $j['telefono']);
        $this->json($j);
    }

    public function guardar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $data = $this->buildData($id);
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['user']) || empty($data['pass'])) {
            $this->json(['success' => false, 'message' => 'Nombre, apellido, usuario y contraseña obligatorios.']);
            return;
        }
        $ok = Juez::crear($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Juez agregado.' : 'Error al agregar.']);
    }

    public function actualizar(): void
    {
        $this->requireAuth();
        $jid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $j = Juez::find($jid);
        if (!$j || $j['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $data = $this->buildData($escuelaId);
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['user'])) {
            $this->json(['success' => false, 'message' => 'Nombre, apellido y usuario obligatorios.']);
            return;
        }
        $ok = Juez::actualizar($jid, $data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Juez actualizado.' : 'Error al actualizar.']);
    }

    public function eliminar(): void
    {
        $this->requireAuth();
        $jid = $this->getInt('id');
        $escuelaId = $_SESSION['escuela_id'];
        $j = Juez::find($jid);
        if (!$j || $j['id_escuela'] != $escuelaId) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        $ok = Juez::delete($jid);
        $this->json(['success' => $ok, 'message' => $ok ? 'Eliminado.' : 'Error al eliminar.']);
    }

    private function buildData(int $idEscuela): array
    {
        return [
            'nombre' => trim($this->getParam('nombre', '')),
            'apellido' => trim($this->getParam('apellido', '')),
            'telefono' => trim($this->getParam('telefono', '')),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'user' => trim($this->getParam('user', '')),
            'pass' => $this->getParam('pass', ''),
            'id_escuela' => $idEscuela,
        ];
    }
}
