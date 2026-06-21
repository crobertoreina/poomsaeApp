<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Escuela;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $escuela = Escuela::find($_SESSION['escuela_id']);
        $this->view('dashboard/index', ['escuela' => $escuela]);
    }
}
