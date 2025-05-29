<!-- app/Views/trajet/create.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un trajet</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Créer un trajet</h2>

  <?php if (!empty($data['errors'])): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($data['errors'] as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Agence de départ</label>
      <select class="form-select" name="agence_depart" required>
        <?php foreach ($data['agences'] as $agence): ?>
          <option value="<?= $agence['id'] ?>"><?= $agence['nom_ville'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Agence d’arrivée</label>
      <select class="form-select" name="agence_arrivee" required>
        <?php foreach ($data['agences'] as $agence): ?>
          <option value="<?= $agence['id'] ?>"><?= $agence['nom_ville'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Date et heure de départ</label>
      <input type="datetime-local" class="form-control" name="date_depart" required>
    </div>
    <div class="mb-3">
      <label>Date et heure d’arrivée</label>
      <input type="datetime-local" class="form-control" name="date_arrivee" required>
    </div>
    <div class="mb-3">
      <label>Nombre de places</label>
      <input type="number" class="form-control" name="places_total" min="1" required>
    </div>
    <button type="submit" class="btn btn-success">Créer le trajet</button>
  </form>
</div>
</body>
</html>
