<!DOCTYPE html>

<html>

<head>
    <title>Gestion des notes - Administrateur</title>
    <link rel="stylesheet" href="../../Administrateur/notes/index_notes.css">
</head>

<body>
<header>
    <h1>Système de Gestion - EFREI</h1>
</header>

<header>
        <h1>EFREI - Personnel Administratif</h1>
        <nav>
            <ul>
                <li><a href="../Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="../Personnel/cours/list_cours.php">Cours</a></li>
                <li><a href="../Personnel/plannings/index_plannings.php">¨Planning</a></li>
                <li><a href="../Personnel/notes/list_notes.php">Notes</a></li>
                <li><a href="../Personnel/user/list_user.php">Utilisateurs</a></li>
            </ul>
        </nav>
    </header>

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
