<?php
// app/Controllers/HomeController.php
/**
 * Contrôleur HomeController
 *
 * Contrôleur principal de la page d'accueil du site.
 * Il récupère les trajets disponibles et les transmet à la vue d'accueil.
 *
 * @package     App\Controllers
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */

require_once '../app/Core/Controller.php';

class HomeController extends Controller {
    public function index() {
        $trajetModel = $this->model('Trajet');
        $trajets = $trajetModel->getTrajetsDisponibles();

        $this->view('home/index', ['trajets' => $trajets]);
    }
}
