<?php
// Redirection si non connecté ou non admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/auth/login');
    exit;
}
$user = $_SESSION['user'];
?>
<?php require_once __DIR__ . '/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tableau de bord</title>
     <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>

<!-- Contenu principal -->
<div class="container mt-5">
    <h1 class="mb-4">Tableau de bord Administrateur</h1>

    <div class="accordion" id="adminAccordion">

        <!-- Utilisateurs -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingUsers">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    👤 Utilisateurs
                </button>
            </h2>
            <div id="collapseUsers" class="accordion-collapse collapse" aria-labelledby="headingUsers" data-bs-parent="#adminAccordion">
                <div class="accordion-body table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($utilisateurs as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                                    <td><?= htmlspecialchars($user['nom']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Agences -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingAgences">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAgences" aria-expanded="false" aria-controls="collapseAgences">
                    🏢 Agences
                </button>
            </h2>
            <div id="collapseAgences" class="accordion-collapse collapse" aria-labelledby="headingAgences" data-bs-parent="#adminAccordion">
                <div class="accordion-body table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Ville</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agences as $agence): ?>
                                <tr>
                                    <td><?= $agence['id'] ?></td>
                                    <td><?= htmlspecialchars($agence['nom_ville']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Trajets -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTrajets">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrajets" aria-expanded="false" aria-controls="collapseTrajets">
                    🚌 Trajets
                </button>
            </h2>
            <div id="collapseTrajets" class="accordion-collapse collapse" aria-labelledby="headingTrajets" data-bs-parent="#adminAccordion">
                <div class="accordion-body table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Départ (date/heure)</th>
                                <th>Arrivée (date/heure)</th>
                                <th>Places</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trajets as $trajet): ?>
                                <?php
                                    $timestampDepart = strtotime($trajet['date_heure_depart']);
                                    if ($timestampDepart < strtotime(date('Y-m-d'))) {
                                        continue; // Ignorer les trajets déjà passés
                                    }
                                    $dateDepart = date('d/m/Y', $timestampDepart);
                                    $heureDepart = date('H:i', $timestampDepart);
                                    $timestampArrivee = strtotime($trajet['date_heure_arrivee']);
                                    $dateArrivee = date('d/m/Y', $timestampArrivee);
                                    $heureArrivee = date('H:i', $timestampArrivee);
                                ?>
                                <tr>
                                    <td><?= $trajet['id'] ?></td>
                                    <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                                    <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                                    <td><?= $dateDepart . ' à ' . $heureDepart ?></td>
                                    <td><?= $dateArrivee . ' à ' . $heureArrivee ?></td>
                                    <td><?= $trajet['places_disponibles'] ?>/<?= $trajet['places_total'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
