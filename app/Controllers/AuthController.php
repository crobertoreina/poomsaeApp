<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Escuela;

class AuthController extends Controller
{
    public function loginView(): void
    {
        $this->view('login/index');
    }

    public function login(): void
    {
        session_start();
        $username = trim($this->getParam('username', ''));
        $password = $this->getParam('password', '');

        $escuela = Escuela::findByCorreo($username) ?: Escuela::findByUser($username);

        if ($escuela && password_verify($password, $escuela['pass'])) {
            if (!$escuela['estado']) {
                $error = 'Cuenta desactivada. Contacta al administrador.';
                $this->view('login/index', ['error' => $error]);
                return;
            }
            $_SESSION['escuela_id'] = $escuela['id'];
            $_SESSION['escuela_nombre'] = $escuela['nombre'];
            $_SESSION['escuela_siglas'] = $escuela['siglas'];
            $this->redirect('/dashboard');
        } else {
            $this->view('login/index', ['error' => 'Credenciales incorrectas.']);
        }
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        $this->redirect('/login');
    }

    public function registroView(): void
    {
        $this->view('escuela/index');
    }

    public function registro(): void
    {
        session_start();
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
            'correo' => trim($this->getParam('correo', '')),
            'user' => trim($this->getParam('user', '')),
            'pass' => $this->getParam('pass', ''),
        ];

        if (!$data['nombre'] || !$data['correo'] || !$data['pass']) {
            $this->view('escuela/index', ['error' => 'Nombre, correo y contraseña son obligatorios.', 'data' => $data]);
            return;
        }

        if (Escuela::findByCorreo($data['correo'])) {
            $this->view('escuela/index', ['error' => 'Este correo ya está registrado.', 'data' => $data]);
            return;
        }

        $result = Escuela::crear($data);
        if ($result) {
            $_SESSION['escuela_id'] = $result['id'];
            $_SESSION['escuela_nombre'] = $data['nombre'];
            $_SESSION['escuela_siglas'] = $data['siglas'];
            $this->redirect('/dashboard');
        } else {
            $this->view('escuela/index', ['error' => 'Error al registrar. Intenta de nuevo.', 'data' => $data]);
        }
    }
}
