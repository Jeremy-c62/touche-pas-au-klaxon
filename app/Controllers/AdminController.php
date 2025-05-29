<?php
// app/Controllers/AdminController.php

/**
 * Contrôleur AdminController
 *
 * Gère toutes les fonctionnalités réservées à l'administrateur :
 * - Authentification de session admin
 * - Tableau de bord administratif
 * - Gestion des utilisateurs (CRUD)
 * - Gestion des agences
 * - Gestion des trajets
 *
 * Méthodes disponibles :
 * - dashboard() : Affiche le tableau de bord avec les statistiques générales
 * - utilisateurs() : Liste les utilisateurs enregistrés
 * - create() : Crée un nouvel utilisateur via formulaire POST
 * - edit($id) : Modifie les données d’un utilisateur existant
 * - delete($id) : Supprime un utilisateur par son ID
 * - agences() : Liste et permet d’ajouter/supprimer des agences
 * - trajets() : Liste et permet de supprimer des trajets
 *
 * Utilise des modèles : Employe, Agence, Trajet
 * Toutes les méthodes nécessitent une session admin active.
 *
 * @package     App\Controllers
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */

class AdminController extends Controller {
    
    // Méthode pour vérifier la session admin et récupérer l'utilisateur connecté
    private function checkAdminSession() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
        return $_SESSION['user'];
    }

    // Tableau de bord pour l'admin
    public function dashboard() {
        $user = $this->checkAdminSession();

        // Charger les modèles
        $userModel = $this->model('Employe');
        $agenceModel = $this->model('Agence');
        $trajetModel = $this->model('Trajet');

        // Récupérer les données
        $utilisateurs = $userModel->getAll();
        $agences = $agenceModel->getAll();
        $trajets = $trajetModel->getAllWithDetails();

        // Passer les données à la vue
        $this->view('admin/dashboard', [
            'utilisateurs' => $utilisateurs,
            'agences' => $agences,
            'trajets' => $trajets,
            'user' => $user
        ]);
    }

    // Affiche la liste des utilisateurs
    public function utilisateurs() {
        $user = $this->checkAdminSession();

        $userModel = $this->model('Employe');
        $utilisateurs = $userModel->getAll();

        $this->view('admin/utilisateurs', [
            'utilisateurs' => $utilisateurs,
            'user' => $user
        ]);
    }

    // Crée un nouvel utilisateur
    public function create() {
        $user = $this->checkAdminSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $role = $_POST['role'];
            $password = $_POST['mot_de_passe'];

            if (empty($prenom) || empty($nom) || empty($email) || empty($telephone) || empty($role) || empty($password)) {
                $_SESSION['error'] = "Tous les champs doivent être remplis.";
                header('Location: ' . BASE_URL . '/admin/create');
                exit;
            }

            $userModel = $this->model('Employe');
            $userModel->create($prenom, $nom, $email, $telephone, $role, $password);

            header('Location: ' . BASE_URL . '/admin/utilisateurs');
            exit;
        }

        $this->view('admin/create', ['user' => $user]);
    }

    // Modifie un utilisateur existant
    public function edit($id) {
        $user = $this->checkAdminSession();

        $userModel = $this->model('Employe');
        $utilisateur = $userModel->find($id);

        if (!$utilisateur) {
            header('Location: ' . BASE_URL . '/admin/utilisateurs');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $role = $_POST['role'];
            $password = isset($_POST['password']) ? $_POST['password'] : null;

            if (empty($prenom) || empty($nom) || empty($email) || empty($telephone) || empty($role)) {
                $_SESSION['error'] = "Tous les champs doivent être remplis.";
                header("Location: " . BASE_URL . "/admin/edit/$id");
                exit;
            }

            $userModel->update($id, $prenom, $nom, $email, $telephone, $role, $password);

            header('Location: ' . BASE_URL . '/admin/utilisateurs');
            exit;
        }

        $this->view('admin/edit', [
            'utilisateur' => $utilisateur,
            'user' => $user
        ]);
    }

    // Supprime un utilisateur
    public function delete($id) {
        $user = $this->checkAdminSession();

        $userModel = $this->model('Employe');
        $userModel->delete($id);

        header('Location: ' . BASE_URL . '/admin/utilisateurs');
        exit;
    }

    // Gère les agences
    public function agences() {
        $user = $this->checkAdminSession();

        $agenceModel = $this->model('Agence');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nom_ville'])) {
                $agenceModel->create($_POST['nom_ville']);
            }
        }

        if (!empty($_GET['delete'])) {
            $agenceModel->delete($_GET['delete']);
        }

        $agences = $agenceModel->getAll();

        $this->view('admin/agences', [
            'agences' => $agences,
            'user' => $user
        ]);
    }

    // Gère les trajets
    public function trajets() {
        $user = $this->checkAdminSession();

        $trajetModel = $this->model('Trajet');

        if (!empty($_GET['delete'])) {
            $trajetModel->delete($_GET['delete']);
        }

        $trajets = $trajetModel->getAllWithDetails();

        $this->view('admin/trajets', [
            'trajets' => $trajets,
            'user' => $user
        ]);
    }
}
