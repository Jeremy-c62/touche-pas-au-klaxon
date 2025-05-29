<?php

// Chargement des fichiers de base
require_once __DIR__ . '/app/Core/App.php';
require_once __DIR__ . '/app/Core/Controller.php';
require_once __DIR__ . '/app/Core/Database.php';

// Si tu as d'autres classes ou fichiers, ajoute-les ici

// Assurez-vous d'automatiser le chargement des classes si nécessaire
spl_autoload_register(function ($class) {
    // Remplace les namespaces pour construire le chemin du fichier
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
});