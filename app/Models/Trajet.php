<?php
// app/Models/Trajet.php
/**
 * Classe Trajet
 *
 * Gère les opérations liées aux trajets.
 *
 * @package App\Models
 * * @author Jeremy
 * @version 1.0
 * @since 27-05-2025
 */

require_once __DIR__ . '/../config/database.php';

class Trajet {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
 /**
     * Récupère tous les trajets avec les informations associées (villes et employé)
     *
     * @return array Tableau associatif contenant les trajets et leurs détails
     */
    public function getAllWithDetails() {
        $query = "
            SELECT t.*, 
                   a1.nom_ville AS ville_depart, 
                   a2.nom_ville AS ville_arrivee,
                   e.prenom, 
                   e.nom
            FROM trajets t
            JOIN agences a1 ON t.agence_depart_id = a1.id
            JOIN agences a2 ON t.agence_arrivee_id = a2.id
            JOIN employes e ON t.employe_id = e.id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
/**
     * Récupère les trajets avec des places disponibles (> 0)
     *
     * @return array Tableau associatif des trajets disponibles
     */
    public function getTrajetsDisponibles() {
        $stmt = $this->conn->prepare("
            SELECT t.id, 
                   a1.nom_ville AS ville_depart, 
                   a2.nom_ville AS ville_arrivee, 
                   t.date_heure_depart, 
                   t.date_heure_arrivee, 
                   t.places_disponibles
            FROM trajets t
            JOIN agences a1 ON t.agence_depart_id = a1.id
            JOIN agences a2 ON t.agence_arrivee_id = a2.id
            WHERE t.places_disponibles > 0
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Récupère tous les trajets avec les informations de l'employé qui les propose
     *
     * @return array Tableau associatif des trajets avec informations de l'employé et des agences
     */
    public function getAllWithProposerInfo() {
        $sql = "
            SELECT 
                t.*, 
                e.nom AS employe_nom, 
                e.prenom AS employe_prenom, 
                e.telephone, 
                e.email,
                a1.nom_ville AS ville_depart,
                a2.nom_ville AS ville_arrivee
            FROM trajets t
            JOIN employes e ON t.employe_id = e.id
            JOIN agences a1 ON t.agence_depart_id = a1.id
            JOIN agences a2 ON t.agence_arrivee_id = a2.id
            ORDER BY t.date_heure_depart ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     /**
     * Récupère tous les trajets proposés par un utilisateur donné
     *
     * @param int $userId ID de l'utilisateur (employé)
     * @return array Tableau associatif des trajets de l'utilisateur
     */
    public function getByUser($userId) {
    $sql = "
        SELECT 
            t.*, 
            a1.nom_ville AS ville_depart,
            a2.nom_ville AS ville_arrivee
        FROM trajets t
        LEFT JOIN agences a1 ON t.agence_depart_id = a1.id
        LEFT JOIN agences a2 ON t.agence_arrivee_id = a2.id
        WHERE t.employe_id = :userId
        ORDER BY t.date_heure_depart ASC
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Crée un nouveau trajet
     *
     * @param int $employe_id ID de l'employé proposant le trajet
     * @param int $agence_depart_id ID de l'agence de départ
     * @param int $agence_arrivee_id ID de l'agence d'arrivée
     * @param string $date_depart Date et heure de départ (format DATETIME)
     * @param string $date_arrivee Date et heure d'arrivée (format DATETIME)
     * @param int $places_total Nombre total de places disponibles
     * @param int $places_disponibles Nombre de places actuellement disponibles
     * @return void
     */

        public function create($employe_id, $agence_depart_id, $agence_arrivee_id, $date_depart, $date_arrivee, $places_total, $places_disponibles) {
    $sql = "INSERT INTO trajets (employe_id, agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee, places_total, places_disponibles)
            VALUES (:employe_id, :depart, :arrivee, :date_depart, :date_arrivee, :total, :disponibles)";
     $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'employe_id' => $employe_id,
        'depart' => $agence_depart_id,
        'arrivee' => $agence_arrivee_id,
        'date_depart' => $date_depart,
        'date_arrivee' => $date_arrivee,
        'total' => $places_total,
        'disponibles' => $places_disponibles
    ]);
    }

    /**
     * Met à jour un trajet
     *
     * @param int $id ID du trajet à mettre à jour
     * @param array $data Données à mettre à jour (clés : agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee, places_total)
     * @return void
     */
public function update($id, $data)
{
    $sql = "UPDATE trajets SET 
        agence_depart_id = :agence_depart_id, 
        agence_arrivee_id = :agence_arrivee_id,
        date_heure_depart = :date_heure_depart, 
        date_heure_arrivee = :date_heure_arrivee,
        places_total = :places_total,
        places_disponibles = :places_disponibles
        WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $data['id'] = $id;
    $stmt->execute($data);
}

   /**
     * Supprime un trajet par son ID
     *
     * @param int $id ID du trajet à supprimer
     * @return void
     */

  public function delete($id) {
    $stmt = $this->conn->prepare("DELETE FROM trajets WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

 /**
     * Récupère un trajet par son ID
     *
     * @param int $id ID du trajet
     * @return array|false Tableau associatif du trajet ou false si non trouvé
     */
public function getById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM trajets WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
