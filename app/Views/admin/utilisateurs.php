<!-- app/views/admin/utilisateurs.php -->
<?php require_once __DIR__ . '/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Liste des utilisateurs</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body>
<div class="container my-5">

    <h2 class="mb-4 text-center">Utilisateurs</h2>

    <!-- tout la partie CRUD Utilisateur et crée si besoin pour une autre application, mais indisponible sur le site.
    <div class="d-flex justify-content-center mb-4">
        <a href="<?= BASE_URL ?>/admin/create" class="btn btn-primary">Ajouter un utilisateur</a>
    </div>
    -->

    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th scope="col">Nom</th>
          <th scope="col">Email</th>
          <th scope="col">Téléphone</th>
          <th scope="col">Rôle</th>
          <!-- <th scope="col">Actions</th> -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['utilisateurs'] as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['telephone']) ?></td>
            <td><?= ucfirst(htmlspecialchars($u['role'])) ?></td>
            <!--
            <td>
              <a href="<?= BASE_URL ?>/admin/edit/<?= $u['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
              <a href="<?= BASE_URL ?>/admin/delete/<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
            </td>
            -->
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

   <div class="mt-3 d-flex justify-content-center">
      <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-secondary">Retour au tableau de bord</a>
   </div>

</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
<!-- Bootstrap JS Bundle (Popper + Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
