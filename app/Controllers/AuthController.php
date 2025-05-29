<?php
// app/Controllers/AuthController.php
/**
 * Contrôleur AuthController
 *
 * Gère l'authentification des utilisateurs :
 * - Connexion avec vérification des identifiants
 * - Déconnexion et destruction de la session
 *
 * Méthodes :
 * - login() : Affiche le formulaire de connexion et gère la connexion via POST
 * - logout() : Déconnecte l'utilisateur en détruisant la session
 *
 * @package     App\Controllers
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */

class AuthController extends Controller {

    public function login() {
        // Si la méthode de la requête est POST (formulaire soumis)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Vérifier si l'utilisateur existe dans la base de données
            $employeModel = $this->model('Employe');
            $user = $employeModel->findByEmail($email);

            // Si l'utilisateur existe et que le mot de passe est correct
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                // Démarrer la session
                session_start();

                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ];

                // Rediriger en fonction du rôle
                if ($_SESSION['user']['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/admin/dashboard');
                    exit;
                } else {
                     header('Location: ' . BASE_URL . '/utilisateur/dashboard');
                    exit;
                }
            } else {
                // Identifiants invalides
                $this->view('auth/login', ['error' => 'Identifiants invalides.']);
                return;
            }
        }

        // GET request : afficher formulaire
        $this->view('auth/login');
    }
    public function logout() {
    session_start();
    session_unset();
    session_destroy();

    header('Location: ' . BASE_URL . '/home');
    exit;
}
}
