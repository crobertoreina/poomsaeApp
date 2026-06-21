<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Juez;

class JuezController extends Controller
{
    public function listar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $jueces = Juez::where('id_escuela', $id);
        $this->json($jueces);
    }

    public function guardar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $data = [
            'nombre' => trim($this->getParam('nombre', '')),
            'apellido' => trim($this->getParam('apellido', '')),
            'telefono' => trim($this->getParam('telefono', '')),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'user' => trim($this->getParam('user', '')),
            'pass' => $this->getParam('pass', ''),
            'id_escuela' => $id,
        ];
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['user']) || empty($data['pass'])) {
            $this->json(['success' => false, 'message' => 'Campos obligatorios faltantes.']);
            return;
        }
        $ok = Juez::crear($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Juez agregado.' : 'Error al agregar.']);
    }

    public function eliminar(): void
    {
        $this->requireAuth();
        $id = $this->getInt('id');
        $ok = Juez::delete($id);
        $this->json(['success' => $ok]);
    }
}
