<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des trajets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Trajets disponibles</h2>

    <div class="row">
        <?php foreach ($data['trajets'] as $trajet): ?>
            <div class="col-md-12">
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?>
                        </h5>
                        <p>
                            Départ : <?= date('d/m/Y H:i', strtotime($trajet['date_heure_depart'])) ?><br>
                            Arrivée : <?= date('d/m/Y H:i', strtotime($trajet['date_heure_arrivee'])) ?><br>
                            Places disponibles : <?= (int)$trajet['places_disponibles'] ?>
                        </p>

                        <!-- Bouton modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?= (int)$trajet['id'] ?>">
                            Détails
                        </button>

                        <!-- Boutons modifier/supprimer si utilisateur connecté et propriétaire -->
                        <?php if (isset($data['user']) && $trajet['employe_id'] == $data['user']['id']): ?>
                            <button onclick='openEditModal(<?= json_encode($trajet) ?>)'>Modifier</button>
                            <a href="/trajet/delete?id=<?= (int)$trajet['id'] ?>" class="btn btn-danger mt-2" 
                               onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal<?= (int)$trajet['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= (int)$trajet['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel<?= (int)$trajet['id'] ?>">Détails du trajet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Proposé par :</strong> <?= htmlspecialchars($trajet['prenom'] ?? '') ?> <?= htmlspecialchars($trajet['nom'] ?? '') ?></p>
                            <p><strong>Email :</strong> <?= htmlspecialchars($trajet['email'] ?? 'Non renseigné') ?></p>
                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['telephone'] ?? 'Non renseigné') ?></p>
                            <p><strong>Places totales :</strong> <?= (int)($trajet['places_total'] ?? 0) ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Charger les fichiers JavaScript Bootstrap à la fin du body -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
