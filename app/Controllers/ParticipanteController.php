<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Escuela;

class ParticipanteController extends Controller
{
    public function listar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $participantes = \App\Models\Participante::where('id_escuela', $id);
        $this->json($participantes);
    }

    public function guardar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $data = [
            'nombre' => trim($this->getParam('nombre', '')),
            'apellido' => trim($this->getParam('apellido', '')),
            'sexo' => $this->getParam('sexo'),
            'fecha_nacimiento' => $this->getParam('fecha_nacimiento'),
            'grado' => trim($this->getParam('grado', '')),
            'cinturon' => trim($this->getParam('cinturon', '')),
            'id_cinturon' => $this->getInt('id_cinturon'),
            'correo' => trim($this->getParam('correo', '')),
            'telefono' => trim($this->getParam('telefono', '')),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'id_escuela' => $id,
        ];
        if (empty($data['nombre']) || empty($data['apellido'])) {
            $this->json(['success' => false, 'message' => 'Nombre y apellido obligatorios.']);
            return;
        }
        $ok = \App\Models\Participante::crear($data);
        $this->json(['success' => $ok, 'message' => $ok ? 'Participante agregado.' : 'Error al agregar.']);
    }

    public function eliminar(): void
    {
        $this->requireAuth();
        $id = $this->getInt('id');
        $ok = \App\Models\Participante::delete($id);
        $this->json(['success' => $ok]);
    }
}
