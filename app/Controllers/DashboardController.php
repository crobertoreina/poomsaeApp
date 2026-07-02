<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Escuela;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        if (($_SESSION['user_level'] ?? 1) == 2) {
            $this->redirect('/evaluacion');
            return;
        }
        $escuela = Escuela::find($_SESSION['escuela_id']);
        $id = (int)$_SESSION['escuela_id'];

        $db = \App\Core\Database::getInstance()->getConnection();
        $stats = [
            'participantes' => $db->query("SELECT COUNT(*) FROM participantes WHERE id_escuela=$id")->fetch_row()[0],
            'jueces' => $db->query("SELECT COUNT(*) FROM jueces WHERE id_escuela=$id")->fetch_row()[0],
            'torneos' => $db->query("SELECT COUNT(*) FROM torneos WHERE id_escuela=$id")->fetch_row()[0],
        ];

        $this->view('dashboard/index', ['escuela' => $escuela, 'stats' => $stats]);
    }
}
