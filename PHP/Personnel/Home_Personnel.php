<?php

session_start();

if ($_SESSION['role'] != 'personnel') {
    header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Personnel Administratif</title>
    <link rel="stylesheet" href="Home_Personnel.css">
</head>
<body>
    <header>
        <h1>EFREI - Personnel Administratif</h1>
        <nav>
            <ul>
                <li><a href="../Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="../Personnel/cours/list_formation.php">Cours</a></li>
                <li><a href="../Personnel/plannings/list_formation.php">Planning</a></li>
                <li><a href="../../Personnel/notes/list_formation.php">Notes</a></li>
                <li><a href="../Personnel/user/list_register.php">Utilisateurs</a></li>
                <li><a href="../Message.php">Messagerie</a></li>
                <li><a href="../logout.php">Deconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="role-section">
            <h3>Informations sur les cours</h3>
            <p>Accédez aux informations sur les cours.</p>
            <a href="../Personnel/cours/list_formation.php">Accéder aux cours</a>
        </section>

        <section class="role-section">
            <h3>Informations sur les plannings</h3>
            <p>Accédez aux informations sur les plannings.</p>
            <a href="../Personnel/plannings/list_formation.php">Accéder aux plannings</a>
        </section>

        <section class="role-section">
            <h3>Informations sur les notes</h3>
            <p>Accédez aux informations sur les notes.</p>
            <a href="../Personnel/notes/list_etudiant_note.php">Accéder aux notes</a>
        </section>

        <section class="role-section">
            <h3>Informations sur les utilisateurs</h3>
            <p>Accédez aux informations sur les utilisateurs.</p>
            <a href="../Personnel/user/list_register.php">Accéder aux utilisateurs</a>
        </section>
    <footer>
        <p>EFREI - Tous droits réservés</p>
    </footer>
</body>
</html>