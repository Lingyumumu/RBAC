<!DOCTYPE html>

<html>

<head>
    <title>Gestion des notes - Administrateur</title>
    <link rel="stylesheet" type="text/css" href="../../index.css">
</head>

<body>
<header>
    <h1>Système de Gestion - EFREI</h1>
</header>

<nav>
    <ul>
        <li><a href="../Home_Admin.php">Accueil</a></li>
        <li><a href="index_notes.php">Notes</a></li>
        <li><a href="../cours/index_cours.php">Cours</a></li>
        <li><a href="../formations/index_formations.php">Formations</a></li>
        <li><a href="../salles/index_salles.php">Salles</a></li>
        <li><a href="../plannings/index_plannings.php">Plannings</a></li>
        <li><a href="../absences/index_absences.php">Absences</a></li>
        <li><a href="etudiants.html">Étudiants</a></li>
        <li><a href="enseignants.html">Enseignants</a></li>
        <li><a href="utilisateurs.html">Utilisateurs</a></li>
        <li><a href="configurations.html">Configurations</a></li>
        <li><a href="securite.html">Sécurité</a></li>
    </ul>
</nav>

<main>
    <h2>Gestion des notes</h2>
    <p>Vous pouvez gérer les informations sur les notes :</p>

    <div class="role-section">
        <h3>Ajouter une note</h3>
        <p>Ajoutez une nouvelle note à la liste des notes.</p>
        <a href="create_note.php">Ajouter une note</a>
    </div>

    <div class="role-section">
        <h3>Modifier une note</h3>
        <p>Modifiez les informations d'une note existante.</p>
        <a href="edit_note.php">Modifier une note</a>
    </div>

    <div class="role-section">
        <h3>Supprimer une note</h3>
        <p>Supprimez une note de la liste des notes.</p>
        <a href="delete_note.php">Supprimer une note</a>
    </div>

    <div class="role-section">
        <h3>Liste des notes</h3>
        <p>Consultez la liste complète des notes.</p>
        <a href="list_note.php">Voir la liste des notes</a>
    </div>
</main>

<footer>
    <p>© 2023 EFREI - Tous droits réservés</p>
</footer>
</body>

</html>
