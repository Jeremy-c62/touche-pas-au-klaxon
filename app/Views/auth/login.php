<!-- app/Views/auth/login.php -->
 <?php 
 /**
 * Vue de la page de connexion utilisateur.
 *
 * Affiche un formulaire de connexion avec les champs email et mot de passe.
 * Utilise Bootstrap 5 pour le style.
 *
 * Variables attendues dans $data :
 * - error (string|null) : message d'erreur à afficher en cas de problème de connexion.
 *
 * @package    App\Views\Auth
 * @author     Jeremy
 * @version    1.0
 * @since      27-05-2025
 */
require_once dirname(__DIR__, 2) . '/config/config.php'; ?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <!-- Lier Bootstrap depuis un CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Connexion</h2>

    <?php if (!empty($data['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($data['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/auth/login">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
  </div>

  <!-- Inclure le script Bootstrap JavaScript depuis un CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
