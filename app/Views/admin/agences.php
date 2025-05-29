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
    <h2 class="mb-4 text-center">Gérer les agences</h2>

    <!-- Formulaire pour ajouter une agence -->
  <div class="d-flex justify-content-center">
    <form action="<?= BASE_URL ?>/admin/agences" method="POST" class="row g-3 mb-4">
        <div class="col-auto">
            <input type="text" name="nom_ville" class="form-control" placeholder="Nom de la ville" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Ajouter une agence</button>
        </div>
    </form>
</div>

    <!-- Liste des agences -->
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">Ville</th>
                <th scope="col" style="width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['agences'] as $agence): ?>
                <tr>
                    <td><?= htmlspecialchars($agence['nom_ville']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/agences?delete=<?= (int)$agence['id'] ?>" 
                           class="btn btn-danger btn-sm" 
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
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>