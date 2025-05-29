<?php

/**
 * Classe Reservation
 *
 * Gère les opérations liées aux réservations des trajets.
 *
 * @package App\Models
 * @author Jeremy
 * @version 1.0
 * @since 27-05-2025
 */
require_once __DIR__ . '/../Core/Model.php';

class Reservation extends Model {
    public function create($trajetId, $employeId, $places) {
        $sql = "INSERT INTO reservations (trajet_id, employe_id, places) 
                VALUES (:trajet_id, :employe_id, :places)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':trajet_id' => $trajetId,
            ':employe_id' => $employeId,
            ':places' => $places
        ]);

        // Met à jour les places disponibles du trajet
        $update = $this->pdo->prepare("
            UPDATE trajets 
            SET places_disponibles = places_disponibles - :places 
            WHERE id = :id
        ");
        $update->execute([
            ':places' => $places,
            ':id' => $trajetId
        ]);
    }

    public function delete($reservationId) {
        // On récupère la réservation pour connaître le nombre de places et le trajet concerné
        $stmt = $this->pdo->prepare("SELECT trajet_id, places FROM reservations WHERE id = :id");
        $stmt->execute([':id' => $reservationId]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            throw new Exception("Réservation introuvable.");
        }

        // Supprimer la réservation
        $delete = $this->pdo->prepare("DELETE FROM reservations WHERE id = :id");
        $delete->execute([':id' => $reservationId]);

        // Rétablir les places disponibles
        $update = $this->pdo->prepare("UPDATE trajets SET places_disponibles = places_disponibles + :places WHERE id = :trajet_id");
        $update->execute([
            ':places' => $reservation['places'],
            ':trajet_id' => $reservation['trajet_id']
        ]);
    }

   public function getByUserWithTrajet($userId) {
    $sql = "SELECT 
                r.id, r.places, 
                ad.nom_ville AS ville_depart, 
                aa.nom_ville AS ville_arrivee, 
                t.date_heure_depart
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            JOIN agences ad ON t.agence_depart_id = ad.id
            JOIN agences aa ON t.agence_arrivee_id = aa.id
            WHERE r.employe_id = :userId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
