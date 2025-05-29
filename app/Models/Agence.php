<?php
/**
 * Modèle Agence
 *
 * Gère les opérations CRUD liées aux agences dans la base de données.
 *
 * @package     App\Models
 * @author      Jeremy
 * @version     1.0
 * @since       27-05-2025
 */

require_once __DIR__ . '/../config/database.php';

class Agence {
    private $conn;

    /**
     * Constructeur
     *
     * Initialise la connexion à la base de données.
     */
    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * Récupère toutes les agences triées par nom de ville.
     *
     * @return array Liste des agences
     */
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM agences ORDER BY nom_ville ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle agence.
     *
     * @param string $nom_ville Nom de la ville de l'agence
     * @return bool Succès ou échec de l'insertion
     */
    public function create($nom_ville) {
        $stmt = $this->conn->prepare("INSERT INTO agences (nom_ville) VALUES (:nom_ville)");
        $stmt->bindParam(':nom_ville', $nom_ville);
        return $stmt->execute();
    }

    /**
     * Supprime une agence par son identifiant.
     *
     * @param int $id Identifiant de l'agence à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM agences WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
