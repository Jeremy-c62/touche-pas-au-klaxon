<?php
// app/Controllers/UtilisateurController.php
/**
 * Contrôleur UtilisateurController
 *
 * Gère le tableau de bord des utilisateurs connectés :
 * - Affiche les trajets disponibles
 * - Affiche les trajets proposés par l'utilisateur
 * - Affiche les réservations de l'utilisateur
 *
 * @package     App\Controllers
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */
class UtilisateurController extends Controller {

  public function dashboard() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }

    $userId = $_SESSION['user']['id'];

    $trajetModel = $this->model('Trajet');
    $agenceModel = $this->model('Agence');
    $reservationModel = $this->model('Reservation');  // <--- ajoute ça

    $trajets = $trajetModel->getAllWithProposerInfo();
    $trajets_user = $trajetModel->getByUser($userId);
    $agences = $agenceModel->getAll();

    // Récupère les réservations de l'utilisateur
    $reservations = $reservationModel->getByUserWithTrajet($userId);

    $this->view('utilisateur/dashboard', [
        'trajets' => $trajets,
        'trajets_user' => $trajets_user,
        'agences' => $agences,
        'reservations' => $reservations, // <--- et ici
    ]);
}

}