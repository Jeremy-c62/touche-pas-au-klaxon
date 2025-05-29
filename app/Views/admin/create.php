<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger" role="alert">
    <?= htmlspecialchars($_SESSION['error']) ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ajouter un utilisateur</title>
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="container my-5">
  <h2 class="mb-4 text-center">Ajouter un utilisateur</h2>

  <form method="POST" action="" class="mx-auto" style="max-width: 500px;">
    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom</label>
      <input type="text" class="form-control" id="prenom" name="prenom" required>
    </div>

    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" class="form-control" id="nom" name="nom" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
      <label for="telephone" class="form-label">Téléphone</label>
      <input type="text" class="form-control" id="telephone" name="telephone" required>
    </div>

    <div class="mb-3">
      <label for="mot_de_passe" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
    </div>

    <div class="mb-4">
      <label for="role" class="form-label">Rôle</label>
      <select class="form-select" id="role" name="role" required>
        <option value="utilisateur">Utilisateur</option>
        <option value="admin">Admin</option>
      </select>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-custom-success">Ajouter</button>

    </div>
    <div class="d-grid mt-3">
      <button type="button" class="btn btn-custom-danger" onclick="history.back()">Retour</button>
    </div>
  </form>
</div>

<!-- Bootstrap JS Bundle (Popper.js inclus) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
