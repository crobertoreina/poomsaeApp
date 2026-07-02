<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Torneo;

class EvaluacionController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        if ($_SESSION['user_level'] != 2) {
            $this->redirect('/dashboard');
            return;
        }
        $idJuez = $_SESSION['juez_id'];
        $torneos = Torneo::listarTorneosPorJuez($idJuez);
        $this->view('evaluacion/index', [
            'torneos' => $torneos,
        ]);
    }

    public function torneo(): void
    {
        $this->requireAuth();
        if ($_SESSION['user_level'] != 2) {
            $this->json([]);
            return;
        }
        $idTorneo = $this->getInt('id');
        $idJuez = $_SESSION['juez_id'];
        $torneo = Torneo::find($idTorneo);
        if (!$torneo) {
            $this->json(['success' => false, 'message' => 'No encontrado.']);
            return;
        }
        if ($torneo['estado'] != 1) {
            $this->json(['success' => false, 'message' => 'El torneo no está activo para evaluación.']);
            return;
        }
        $categorias = Torneo::listarCategorias($idTorneo);
        $participantes = Torneo::listarParticipantesParaJuez($idTorneo);
        $puntajes = [];
        foreach ($participantes as $p) {
            $punt = Torneo::obtenerPuntaje($idTorneo, $p['id'], $idJuez);
            if ($punt) {
                $puntajes[$p['id']] = [
                    'puntaje' => (float)$punt['puntaje'],
                    'fuerza_velocidad' => (float)($punt['fuerza_velocidad'] ?? 0),
                    'ritmo_tiempo' => (float)($punt['ritmo_tiempo'] ?? 0),
                    'expresion_energia' => (float)($punt['expresion_energia'] ?? 0),
                ];
            } else {
                $puntajes[$p['id']] = null;
            }
        }
        $this->json([
            'success' => true,
            'torneo' => $torneo,
            'categorias' => $categorias,
            'participantes' => $participantes,
            'puntajes' => $puntajes,
        ]);
    }

    public function guardarPuntaje(): void
    {
        $this->requireAuth();
        if ($_SESSION['user_level'] != 2) {
            $this->json(['success' => false, 'message' => 'Acceso denegado.']);
            return;
        }
        $idTorneo = $this->getInt('id_torneo');
        $idParticipante = $this->getInt('id_participante');
        $idCategoria = $this->getInt('id_categoria') ?: null;
        $idJuez = $_SESSION['juez_id'];
        $puntaje = (float)$this->getParam('puntaje', '4.0');
        $fuerzaVelocidad = (float)$this->getParam('fuerza_velocidad', '0');
        $ritmoTiempo = (float)$this->getParam('ritmo_tiempo', '0');
        $expresionEnergia = (float)$this->getParam('expresion_energia', '0');

        if ($puntaje < 0) $puntaje = 0;
        if ($puntaje > 4.0) $puntaje = 4.0;
        if ($fuerzaVelocidad < 0) $fuerzaVelocidad = 0;
        if ($fuerzaVelocidad > 2.0) $fuerzaVelocidad = 2.0;
        if ($ritmoTiempo < 0) $ritmoTiempo = 0;
        if ($ritmoTiempo > 2.0) $ritmoTiempo = 2.0;
        if ($expresionEnergia < 0) $expresionEnergia = 0;
        if ($expresionEnergia > 2.0) $expresionEnergia = 2.0;

        // Check tournament is active
        $torneo = Torneo::find($idTorneo);
        if (!$torneo || $torneo['estado'] != 1) {
            $this->json(['success' => false, 'message' => 'El torneo no está activo para evaluación.']);
            return;
        }

        // Check if already evaluated
        $existente = Torneo::obtenerPuntaje($idTorneo, $idParticipante, $idJuez);
        if ($existente !== null) {
            $this->json(['success' => false, 'message' => 'Ya evaluaste a este participante. No puedes cambiar el puntaje.']);
            return;
        }

        $ok = Torneo::guardarPuntaje($idTorneo, $idCategoria, $idParticipante, $idJuez, $puntaje, $fuerzaVelocidad, $ritmoTiempo, $expresionEnergia);
        $this->json(['success' => $ok, 'message' => $ok ? 'Puntaje guardado.' : 'Error al guardar.']);
    }
}
