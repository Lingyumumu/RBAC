<?php
session_start();
if ($_SESSION['role'] != 'professeur') {
    header("location: ../login.php");
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Accueil - Professeur</title>
    <link rel="stylesheet" type="text/css" href="../Professeur/Home_Professeur.css">
</head>

<body>
    <header>
        <h1>Système de Gestion - EFREI</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../Professeur/Home_Professeur.php">Accueil</a></li>
            <li><a href="../Professeur/notes/list_etudiant_note.php">Notes</a></li>
            <li><a href="cours_assigner.php">Document</a></li>
            <li><a href="../Professeur/plannings/list_planning.php">Planning</a></li>
            <li><a href="../logout.php">Deconnexion</a></li>
        </ul>
    </nav>

    <main>
        <h2>Bienvenue, Professeur</h2>
        <p>En tant que professeur, vous avez accès à certaines fonctionnalités du système :</p>

        <div class="role-section">
            <h3>Notes</h3>
            <p>Consultez les notes des étudiants inscrits à vos cours et enregistrez leurs performances académiques.</p>
            <a href="../Professeur/notes/list_etudiant_note.php">Consulter les notes</a>
        </div>

        <div class="role-section">
            <h3>Document</h3>
            <p>Consultez les documents de cours et devoirs des étudiants.</p>
            <a href="cours_assigner.php">Consulter les Documents</a>
        </div>

        <div class="role-section">
            <h3>Horaires</h3>
            <p>Consultez les horaires de vos cours et des événements.</p>
            <a href="../Professeur/plannings/list_planning.php">Consulter les horaires</a>
        </div>
    </main>

    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>

</html>