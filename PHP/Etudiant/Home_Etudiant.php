<?php

session_start();

if (isset($_SESSION['ID']) == null) {
    header("location: ../login.php");
}
else{
    $role = $_SESSION['role'];
    $id =   $_SESSION['ID'];
}

session_write_close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page d'accueil - Étudiant</title>
    <link rel="stylesheet" type="text/css" href="Home_Etudiant.css">
</head>

<body>
    <header>
        <h1>Système de gestion de l'EFREI</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../Etudiant/Home_Etudiant.php">Accueil</a></li>
            <li><a href="../Etudiant/plannings/list_planning.php">Mon emploi-du-temps</a></li>
            <li><a href="../Etudiant/cours_inscrit.php">Cours</a></li>
            <li><a href="../Etudiant/notes/list_note.php">Mes notes</a></li>
            <?php echo '<li><td><a href="mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
            <li><a href="../logout.php">Deconnexion</a></li>


        </ul>
    </nav>

    <main>
        <h2>Bienvenue, Étudiant</h2>
        <p>En tant qu'étudiant, vous pouvez accéder aux fonctionnalités suivantes :</p>

        <div class="role-section">
            <h3>Emploi du temps</h3>
            <p>Consultez votre emploi du temps pour connaître vos cours et horaires.</p>
            <a href="../Etudiant/plannings/list_planning.php">Voir l'emploi du temps</a>
        </div>

        <div class="role-section">
            <h3>Mes notes</h3>
            <p>Consultez vos notes pour suivre vos performances académiques.</p>
            <a href="../Etudiant/notes/list_note.php">Voir mes notes</a>
        </div>

        </div>

        <div class="role-section">
            <h3>Absences</h3>
            <p>Consultez les informations sur les absences et les congés.</p>
            <a href="../Etudiant/mes_absences.php">Voir les absences</a>
        </div>

        <div class="role-section">
            <h3>Documents</h3>
            <p>Consultez les documents mis à disposition par les professeurs.</p>
            <a href="../Etudiant/cours_inscrit.php">Voir les documents</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 EFREI. Tous droits réservés.</p>
    </footer>
</body>

</html>