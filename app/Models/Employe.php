<?php
// app/Models/Employe.php

/**
 * Classe Employe - Gestion des employés
 *
 * Cette classe permet de gérer les opérations CRUD sur la table `employes`.
 *
 * @package App\Models
 * @author Jeremy
 * @version 1.0
 * @since 27-05-2025
 */
require_once dirname(__DIR__) . '/config/database.php';

class Employe {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Récupère tous les employés
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM employes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Créer un employé
    public function create($prenom, $nom, $email, $telephone, $role, $mot_de_passe) {
    // Hachage du mot de passe
    $hashedPassword = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    $stmt = $this->conn->prepare("INSERT INTO employes (prenom, nom, email, telephone, mot_de_passe, role) 
                                  VALUES (:prenom, :nom, :email, :telephone, :mot_de_passe, :role)");

    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':mot_de_passe', $hashedPassword);
    $stmt->bindParam(':role', $role);

    return $stmt->execute();
}

    // Trouver un employé par son ID
    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM employes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un employé
    public function update($id, $prenom, $nom, $email, $telephone, $role) {
        $stmt = $this->conn->prepare("UPDATE employes SET prenom = :prenom, nom = :nom, email = :email, telephone = :telephone, role = :role WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    }

    // Supprimer un employé
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM employes WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function getById($id) {
    $query = "SELECT * FROM employes WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    // Récupérer un employé par son email
    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM employes WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
