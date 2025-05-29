<?php
// app/Controllers/TrajetController.php
/**
 * Contrôleur TrajetController
 *
 * Gère les opérations CRUD liées aux trajets :
 * - Création, lecture, mise à jour et suppression de trajets
 * - Vérification des données de formulaire
 * - Affichage des vues associées
 *
 * @package     App\Controllers
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */
session_start();
class TrajetController extends Controller {
    public function creer() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        $agenceModel = $this->model('Agence');
        $agences = $agenceModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'agence_depart' => $_POST['agence_depart'],
                'agence_arrivee' => $_POST['agence_arrivee'],
                'date_depart' => $_POST['date_depart'],
                'date_arrivee' => $_POST['date_arrivee'],
                'places_total' => (int)$_POST['places_total'],
                'employe_id' => $_SESSION['user']['id']
            ];

            $errors = [];

            if ($data['agence_depart'] === $data['agence_arrivee']) {
                $errors[] = "Les agences de départ et d’arrivée doivent être différentes.";
            }

            if (strtotime($data['date_arrivee']) <= strtotime($data['date_depart'])) {
                $errors[] = "La date d’arrivée doit être postérieure à celle du départ.";
            }

            if ($data['places_total'] < 1) {
                $errors[] = "Il faut au moins une place disponible.";
            }

            if (empty($errors)) {
                $trajetModel = $this->model('Trajet');
                $trajetModel->create($data);
                header('Location: /home/index');
                exit;
            }

            $this->view('trajet/create', ['agences' => $agences, 'errors' => $errors]);
            return;
        }

        $this->view('trajet/create', ['agences' => $agences]);
    }
    
public function store() {
    // Vérifier si les données du formulaire sont envoyées
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier que toutes les données sont présentes
        if (isset($_POST['agence_depart_id'], $_POST['agence_arrivee_id'], $_POST['date_heure_depart'], $_POST['date_heure_arrivee'], $_POST['places_total'])) {
            
            // Instancier le modèle Trajet
            $trajetModel = $this->model('Trajet');
            
            // Calculer les places disponibles (initialement égales aux places totales)
            $places_total = (int)$_POST['places_total'];
            $places_disponibles = $places_total;

            // Appeler une méthode du modèle pour insérer un nouveau trajet
            $trajetModel->create(
                $_POST['employe_id'],          // L'ID de l'employé (probablement de la session utilisateur)
                $_POST['agence_depart_id'],    // ID de l'agence de départ
                $_POST['agence_arrivee_id'],   // ID de l'agence d'arrivée
                $_POST['date_heure_depart'],   // Date et heure du départ
                $_POST['date_heure_arrivee'],  // Date et heure d'arrivée
                $places_total,                 // Places totales
                $places_disponibles            // Places disponibles
            );

            // Rediriger l'utilisateur vers son tableau de bord après la création du trajet
            header('Location: ' . BASE_URL . '/utilisateur/dashboard');
            exit;
        } else {
            // Gérer le cas où des données sont manquantes dans le formulaire
            echo "Veuillez remplir tous les champs du formulaire.";
        }
    }
}
public function delete($id) {
    $trajetModel = $this->model('Trajet');
    $trajetModel->delete($id);
    header('Location: ' . BASE_URL . '/utilisateur/dashboard');
    exit;
}
public function edit($id) {
    $trajetModel = $this->model('Trajet');
    $agenceModel = $this->model('Agence');

    $trajet = $trajetModel->getById($id);
    $agences = $agenceModel->getAll();

    $this->view('trajet/edit', [
        'trajet' => $trajet,
        'agences' => $agences
    ]);
}
public function update()
{
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }

    $id = $_POST['trajet_id'] ?? null;

    if (!$id) {
        echo "Erreur : ID du trajet manquant.";
        exit;
    }

    $agence_depart_id = $_POST['agence_depart_id'];
    $agence_arrivee_id = $_POST['agence_arrivee_id'];
    $date_heure_depart = $_POST['date_heure_depart'];
    $date_heure_arrivee = $_POST['date_heure_arrivee'];
    $places_total = (int) $_POST['places_total'];

    $trajetModel = $this->model('Trajet');
    $trajet = $trajetModel->getById($id);

    if (!$trajet) {
        echo "Erreur : Trajet non trouvé.";
        exit;
    }

    $places_disponibles = $trajet['places_disponibles'] + ($places_total - $trajet['places_total']);

    if ($places_disponibles < 0) {
        $places_disponibles = 0;
    }
    if ($places_disponibles > $places_total) {
        $places_disponibles = $places_total;
    }

    $trajetModel->update($id, [
        'agence_depart_id' => $agence_depart_id,
        'agence_arrivee_id' => $agence_arrivee_id,
        'date_heure_depart' => $date_heure_depart,
        'date_heure_arrivee' => $date_heure_arrivee,
        'places_total' => $places_total,
        'places_disponibles' => $places_disponibles
    ]);

    header('Location: ' . BASE_URL . '/utilisateur/dashboard');
    exit;
}




        public function index() {
    $trajetModel = $this->model('Trajet');
    $trajets = $trajetModel->getAllWithDetails();

    // Assure-toi que tu as une vue à cet emplacement
    $this->view('trajet/index', ['trajets' => $trajets]);
}
    }

