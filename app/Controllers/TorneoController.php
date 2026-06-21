<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Torneo;

class TorneoController extends Controller
{
    public function listar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $torneos = Torneo::where('id_escuela', $id);
        $this->json($torneos);
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
            'id_escuela' => $id,
        ];
        if (empty($data['nombre']) || empty($data['fecha'])) {
            $this->json(['success' => false, 'message' => 'Nombre y fecha obligatorios.']);
            return;
        }
        $ok = Torneo::crear($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Torneo creado.' : 'Error al crear.']);
    }

    public function eliminar(): void
    {
        $this->requireAuth();
        $id = $this->getInt('id');
        $ok = Torneo::delete($id);
        $this->json(['success' => $ok]);
    }
}
