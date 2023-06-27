<!DOCTYPE html>

<html>

<head>
    <title>Gestion des plannings - Administrateur</title>
    <link rel="stylesheet" type="text/css" href="../../../CSS/Home_Admin.css">
</head>

<body>
<header>
    <h1>Système de Gestion - EFREI</h1>
</header>

<nav>
    <ul>
        <li><a href="../Home_Admin.php">Accueil</a></li>
        <li><a href="../notes/index_notes.php">Notes</a></li>
        <li><a href="../cours/index_cours.php">Cours</a></li>
        <li><a href="../formations/index_formations.php">Formations</a></li>
        <li><a href="../salles/index_salles.php">Salles</a></li>
        <li><a href="index_plannings.php">Plannings</a></li>
        <li><a href="../absences/index_absences.php">Absences</a></li>
        <li><a href="etudiants.html">Étudiants</a></li>
        <li><a href="enseignants.html">Enseignants</a></li>
        <li><a href="utilisateurs.html">Utilisateurs</a></li>
        <li><a href="configurations.html">Configurations</a></li>
        <li><a href="securite.html">Sécurité</a></li>
    </ul>
</nav>

<main>
    <h2>Gestion des plannings</h2>
    <p>Vous pouvez gérer les informations sur les plannings à l'EFREI :</p>

    <div class="role-section">
        <h3>Ajouter un planning</h3>
        <p>Ajoutez un nouveau planning</p>
        <a href="create_planning.php">Ajouter un planning</a>
    </div>

    <div class="role-section">
        <h3>Modifier un planning</h3>
        <p>Modifiez les informations d'un planning existant.</p>
        <a href="edit_planning.php">Modifier un planning</a>
    </div>

    <div class="role-section">
        <h3>Supprimer un planning</h3>
        <p>Supprimez un planning de la liste des planning.</p>
        <a href="delete_planning.php">Supprimer un planning</a>
    </div>

    <div class="role-section">
        <h3>Liste des plannings</h3>
        <p>Consultez la liste complète des plannings.</p>
        <a href="list_planning.php">Voir la liste des plannings</a>
    </div>
</main>

<footer>
    <p>© 2023 EFREI - Tous droits réservés</p>
</footer>
</body>

</html>
