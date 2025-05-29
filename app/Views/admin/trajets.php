<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Liste des trajets</title>
    <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>

<?php require_once __DIR__ . '/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Trajets</h2>

    <?php
    $now = new DateTime();
    $showPast = (isset($_GET['show']) && $_GET['show'] === 'past');
    ?>

    <div class="mb-3 text-center">
        <?php if ($showPast): ?>
            <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>" class="btn btn-primary">
                Afficher uniquement les trajets futurs
            </a>
        <?php else: ?>
            <a href="?show=past" class="btn btn-secondary">
                Afficher tous les trajets (passés et futurs)
            </a>
        <?php endif; ?>
    </div>

    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">Départ</th>
                <th scope="col">Arrivée</th>
                <th scope="col">Date</th>
                <th scope="col">Proposé par</th>
                <th scope="col">Places</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data['trajets'] as $t): 
            $dateDepart = new DateTime($t['date_heure_depart']);
            if (!$showPast && $dateDepart < $now) {
                continue; // ne pas afficher ce trajet
            }
        ?>
            <tr>
                <td><?= htmlspecialchars($t['ville_depart']) ?></td>
                <td><?= htmlspecialchars($t['ville_arrivee']) ?></td>
                <td><?= $dateDepart->format('d/m/Y H:i') ?></td>
                <td><?= htmlspecialchars($t['prenom'] . ' ' . $t['nom']) ?></td>
                <td><?= (int)$t['places_disponibles'] ?>/<?= (int)$t['places_total'] ?></td>
                <td>
                    <a href="?delete=<?= (int)$t['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-secondary">Retour au tableau de bord</a>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
