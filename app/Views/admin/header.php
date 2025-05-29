<?php
// header.php
// On suppose que la variable $data['user'] est disponible et contient les infos utilisateur
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="<?= BASE_URL ?>/admin/dashboard">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/utilisateurs">Utilisateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/agences">Agences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/trajets">Trajets</a>
            </li>
            <li class="nav-item">
                <span class="navbar-text text-white mx-3">Bonjour, <?= htmlspecialchars($data['user']['prenom']) ?></span>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>/auth/logout">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
