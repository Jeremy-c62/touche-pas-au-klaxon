<?php require_once dirname(__DIR__, 2) . '/config/config.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page d'accueil</title>
  <!-- Bootstrap CSS compilé avec ta palette -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">Touche pas au klaxon</span>
      <div class="d-flex">
        <?php if (!isset($_SESSION['user'])): ?>
          <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline-light">Se connecter</a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-outline-danger">Se déconnecter</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Main content -->
  <div class="container mt-5">
    <h1 class="mb-4">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter.</h1>

    <?php if (empty($data['trajets'])): ?>
      <div class="alert alert-warning">Aucun trajet disponible.</div>
    <?php else: ?>
      <?php
        // Trier les trajets par date_heure_depart croissante (de la plus proche à la plus lointaine)
        usort($data['trajets'], function($a, $b) {
          return strtotime($a['date_heure_depart']) <=> strtotime($b['date_heure_depart']);
        });
      ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>Départ</th>
              <th>Date départ</th>
              <th>Heure départ</th>
              <th>Arrivée</th>
              <th>Date arrivée</th>
              <th>Heure arrivée</th>
              <th>Places restantes</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['trajets'] as $trajet): ?>
              <?php
                $timestampDepart = strtotime($trajet['date_heure_depart']);
                if ($timestampDepart < strtotime(date('Y-m-d'))) {
                  continue; // Ne pas afficher les trajets passés
                }

                $dateDepart = date('d/m/Y', $timestampDepart);
                $heureDepart = date('H:i', $timestampDepart);
                $dateArrivee = date('d/m/Y', strtotime($trajet['date_heure_arrivee']));
                $heureArrivee = date('H:i', strtotime($trajet['date_heure_arrivee']));
              ?>
              <tr>
                <td><?= htmlspecialchars($trajet['ville_depart']) ?></td>
                <td><?= $dateDepart ?></td>
                <td><?= $heureDepart ?></td>
                <td><?= htmlspecialchars($trajet['ville_arrivee']) ?></td>
                <td><?= $dateArrivee ?></td>
                <td><?= $heureArrivee ?></td>
                <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
<?php include dirname(__DIR__) . '/layout/footer.php'; ?>

  <!-- Bootstrap JS via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
