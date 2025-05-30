README - Application de Covoiturage
A/ Présentation générale

Cette application de covoiturage est développée en PHP afin de bénéficier de sa simplicité, sa robustesse, et sa large compatibilité avec les serveurs web classiques. Elle permet de gérer efficacement des trajets partagés entre utilisateurs, tout en offrant un tableau de bord complet pour les administrateurs.

B/ Fonctionnalités principales

1. Gestion des utilisateurs

   Les utilisateurs peuvent créer un compte, se connecter, et accéder à leur tableau de bord.
   Ils peuvent visualiser les trajets disponibles, effectuer des réservations sur ces trajets, et consulter les informations de contact (email, téléphone) des conducteurs pour faciliter la communication.

2. Tableau de bord utilisateur

   Affichage des trajets disponibles, uniquement ceux dont la date de départ est future.
   Possibilité de réserver des places sur les trajets.
   Consultation des coordonnées de la personne ayant proposé le trajet pour faciliter les échanges.

3. Tableau de bord administrateur

   Accès restreint aux administrateurs.
   Gestion complète des utilisateurs (ajout, modification, suppression).
   Gestion des agences (villes, localisation).
   Gestion des trajets (création, modification, suppression).
   Affichage uniquement des trajets dont la date de départ est future.
   Protection par rôle, permettant un contrôle sécurisé des accès.

C/ Structure et fonctionnement technique

    Le projet est basé sur PHP avec sessions pour la gestion des connexions.
    Bootstrap est utilisé pour l’interface graphique et la responsivité.
    Les données sont récupérées et affichées via des tableaux dynamiques.
    Les dates sont formatées en français (JJ/MM/AAAA) pour une meilleure lisibilité.
    Les trajets passés ne sont pas affichés pour éviter toute confusion.

D/ Base de données

    La base de données contient les tables suivantes :
        utilisateurs (id, prénom, nom, email, rôle, etc.)
        agences (id, nom_ville)
        trajets (id, ville_depart, ville_arrivee, date_heure_depart, date_heure_arrivee, places_disponibles, places_total, contact)
    Important : La base de données est à compléter et enrichir par le service RH et les administrateurs pour intégrer les informations spécifiques à l’entreprise et permettre une utilisation optimale dans le cadre d’autres projets.

E/ Initialisation du projet avec XAMPP

1.  Prérequis

    XAMPP installé (PHP ≥ 7.4, Apache, MySQL).

    Git installé pour cloner le dépôt.

    Node.js & npm pour compiler les fichiers SCSS.

    Navigateur récent (Chrome, Firefox…).

2.  Étapes d'installation
    Démarrage de XAMPP
    Ouvrir XAMPP Control Panel.

    Démarrer Apache et MySQL.
    Préparer le projet:
    Dans le terminal:
    cd C:\xampp\htdocs  
     mkdir covoiturage
    cd covoiturage
    git clone https://github.com/TON_COMPTE/touchepasauxklaxon.git .
    Installer les dépendances front-end
    npm install
    npm run build-css
    Créer la base de données:
    Créer une base nommée covoiturage
    ou Importer le fichier SQL fourni

    Configuration de la base de données:
    app/config/database.php
    return [
    'host' => '....',

            'dbname' => '....',

            'user' => '....',

            'password' => '....',
        ];

    Connexion avec le site existant :

        Ajouter un lien dans la navigation principale de votre site vers l’application de covoiturage.
        Pour une intégration plus poussée, utiliser les sessions existantes pour gérer les connexions utilisateurs (adapter le système ’authentification).
        Harmoniser les styles CSS et les éléments graphiques pour un rendu cohérent avec le site principal.

    Sécurité :

        Veiller à bien configurer les permissions des fichiers.
        Mettre en place un certificat SSL (HTTPS) pour sécuriser les échanges.
        Vérifier les rôles utilisateurs pour éviter les accès non autorisés.

F/ Conclusion

Cette application offre un système complet et simple de covoiturage, adaptable aux besoins de votre entreprise. Grâce à son interface utilisateur intuitive et à son tableau de bord d’administration puissant, elle facilite la gestion des trajets et des utilisateurs tout en garantissant une communication fluide entre conducteurs et passagers.
