<?php
/**
 * Contrôleur ReservationController
 *
 * Gère les actions liées aux réservations :
 * - Création d'une réservation pour un trajet
 * - Suppression (annulation) d'une réservation existante
 *
 * Accessible uniquement aux utilisateurs connectés ayant le rôle "utilisateur".
 *
 * @package     App\Controllers
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */

class ReservationController extends Controller {
    public function store() {
        session_start();

        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        // Vérifie que c'est un employé
        if ($_SESSION['user']['role'] !== 'utilisateur') {
            die('Seuls les utilisateurs peuvent effectuer une réservation.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trajetId = $_POST['trajet_id'];
            $employeId = $_SESSION['user']['id'];
            $places = (int)$_POST['places_reservees'];

            $reservationModel = $this->model('Reservation');
            $reservationModel->create($trajetId, $employeId, $places);

            header('Location: ' . BASE_URL . '/utilisateur/dashboard');
            exit;
        }

        die('Méthode non autorisée.');
    }

    public function delete() {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservationId = $_POST['reservation_id'];

            $reservationModel = $this->model('Reservation');

            try {
                $reservationModel->delete($reservationId);
                header('Location: ' . BASE_URL . '/utilisateur/dashboard');
                exit;
            } catch (Exception $e) {
                die('Erreur lors de l\'annulation : ' . $e->getMessage());
            }
        }

        die('Méthode non autorisée.');
    }
}
