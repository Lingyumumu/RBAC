<?php

    session_start();
    if ($_SESSION['role'] != 'administrateur') {
        header("location: ../login.php");
    }
?>


<!DOCTYPE html>
<html>

<head>
    <title>Accueil - Administrateur</title>
    <link rel="stylesheet" type="text/css" href="Home_Admin.css">
</head>

<body>
    <header>
        <h1>Système de Gestion - EFREI</h1>
    </header>

    <nav>
        <ul>
            <li><a href="Home_Admin.php">Accueil</a></li>
            <li><a href="../Administrateur/notes/list_formation.php">Notes</a></li>
            <li><a href="../Administrateur/cours/list_formation.php">Cours</a></li>
            <li><a href="../Administrateur/formations/list_formation.php">Formations</a></li>
            <li><a href="../Administrateur/document/list_documents.php">document</a></li>
            <li><a href="../Administrateur/plannings/list_formation.php">Planning</a></li>
            <li><a href="../Administrateur/user/list_user.php">Utilisateurs</a></li>
            <li><a href="../Administrateur/user/list_register.php">Inscription</a></li>
        </ul>
    </nav>

    <main>
        <h2>Bienvenue, Administrateur</h2>
        <p>En tant qu'administrateur, vous avez accès à toutes les fonctionnalités du système :</p>

        <div class="role-section">
            <h3>Notes</h3>
            <p>Gérez les notes des étudiants et consultez les performances académiques.</p>
            <a href="../Administrateur/notes/index_notes.php">Gérer les notes</a>
        </div>

        <div class="role-section">
            <h3>Cours</h3>
            <p>Gérez les informations sur les cours dispensés à l'EFREI.</p>
            <a href="../Administrateur/cours/list_cours.php">Gérer les cours</a>
        </div>

        <div class="role-section">
            <h3>Formations</h3>
            <p>Gérez les informations sur les formations</p>
            <a href="../Administrateur/formations/list_formation.php">Gérer les formations</a>
        </div>

        <div class="role-section">
            <h3>Document</h3>
            <p>Gérez les documents des cours et des événements.</p>
            <a href="../Administrateur/document/list_documents.php">Gérer les documents</a>
        </div>

        <div class="role-section">
            <h3>Planning</h3>
            <p>Gérez les informations sur les plannings des étudiants et des enseignants.</p>
            <a href="../Administrateur/plannings/index_plannings.php">Gérer les plannings</a>
        </div>

        <div class="role-section">
            <h3>Utilisateurs</h3>
            <p>Gérez les utilisateurs du système et leurs permissions.</p>
            <a href="../Administrateur/user/list_user.php">Gérer les utilisateurs</a>
        </div>

        <div class="role-section">
            <h3>Inscription</h3>
            <p>Configurez les inscriptions</p>
            <a href="../Administrateur/user/list_register.php">Gérer les inscriptions</a>
        </div>
    </main>

    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>

</html>