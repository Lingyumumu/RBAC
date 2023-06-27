<?php
include('../../dbConn.php');

// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT cours.*, user.prenom AS nom_enseignant, formations.nom AS nom_formation
               FROM cours
               INNER JOIN user ON cours.nom_prof = user.nom
               INNER JOIN formations ON cours.nom_formation = formations.nom";




$resultCours = mysqli_query($connection, $queryCours);

// Fermer la connexion à la base de données
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<header>
    <h1>Système de Gestion - EFREI</h1>
    <link rel="stylesheet" href="list_cours.css">
</header>
<head>
    <title>Liste des cours - Administrateur</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
<nav>
    <ul>
        <li><a href="../Home_Admin.php">Accueil</a></li>
        <li><a href="../notes/index_notes.php">Notes</a></li>
        <li><a href="index_cours.php">Cours</a></li>
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

<a href='create_cours.php'>ajouter un cours</a>

<h2>Liste des cours</h2>

<?php
// Vérifier si des cours ont été trouvés
if (mysqli_num_rows($resultCours) > 0) {
    // Afficher les cours dans un tableau
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Enseignant assigné</th>
                <th>Nom du cours</th>
                <th>Formation</th>
                <th colspan='4'>Actions</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultCours)) {
        $idCours = $row['ID'];
        $enseignant = $row['nom_enseignant'];
        $nomCours = $row['nom_cours'];
        $formation = $row['nom_formation'];

        echo "<tr>
                <td>$idCours</td>
                <td>$enseignant</td>
                <td>$nomCours</td>
                <td>$formation</td>
                <td><a href='../plannings/create_planning.php?ID=$idCours'>Planning</a></td>
                <td><a href='create_prof.php?ID=$idCours'>Ajouter un prof</a></td>
                <td><a href='edit_cours.php?ID=$idCours'>Modifier</a></td>
                <td><a href='delete_cours.php?id=$idCours'>Supprimer</a></td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>

</body>
</html>
