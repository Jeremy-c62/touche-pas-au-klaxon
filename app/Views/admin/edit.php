<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifier l'utilisateur</title>
  <!-- CSS compilé SASS + Bootstrap -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>
  <div class="container my-5">
    <h2>Modifier l'utilisateur</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mx-auto" style="max-width: 500px;">
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?php echo isset($utilisateur['prenom']) ? $utilisateur['prenom'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="<?php echo isset($utilisateur['nom']) ? $utilisateur['nom'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo isset($utilisateur['email']) ? $utilisateur['email'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control" value="<?php echo isset($utilisateur['telephone']) ? $utilisateur['telephone'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <select name="role" class="form-select">
                <option value="utilisateur" <?php echo ($utilisateur['role'] === 'utilisateur') ? 'selected' : ''; ?>>Utilisateur</option>
                <option value="admin" <?php echo ($utilisateur['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe (optionnel)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
        <div class="d-grid mt-3">
      <button type="button" class="btn btn-custom-danger" onclick="history.back()">Retour</button>
    </div>
    </form>
  </div>

  <!-- Bootstrap JS Bundle (Popper inclus) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
