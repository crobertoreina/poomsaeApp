<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Escuela;

class EscuelaController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $escuela = Escuela::find($_SESSION['escuela_id']);
        $this->view('escuela/index', ['data' => $escuela, 'editando' => true]);
    }

    public function editar(): void
    {
        $this->requireAuth();
        $id = $_SESSION['escuela_id'];
        $data = [
            'nombre' => trim($this->getParam('nombre', '')),
            'siglas' => trim($this->getParam('siglas', '')),
            'fecha_fundacion' => $this->getParam('fecha_fundacion'),
            'instructor_nombre' => trim($this->getParam('instructor_nombre', '')),
            'instructor_grado' => trim($this->getParam('instructor_grado', '')),
            'telefono' => trim($this->getParam('telefono', '')),
            'pais' => trim($this->getParam('pais', '')),
            'ciudad' => trim($this->getParam('ciudad', '')),
            'direccion' => trim($this->getParam('direccion', '')),
        ];
        Escuela::actualizar($id, $data);
        header('Location: ' . base_url('/dashboard'));
        exit;
    }
}
