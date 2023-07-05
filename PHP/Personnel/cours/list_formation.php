<?php
include('../../dbConn.php');
session_start();
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
    <link rel="stylesheet" href="../../Administrateur/cours/list_cours.css">
    <h1>Système de Gestion - EFREI</h1>
</header>
<head>
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
<h1>EFREI - Personnel Administratif</h1>
        <nav>
            <ul>
                <li><a href="../../Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="../../Personnel/cours/list_formation.php">Cours</a></li>
                <li><a href="../../Personnel/plannings/list_formation.php">Planning</a></li>
                <li><a href="../../Personnel/notes/list_formation.php">Notes</a></li>
                <li><a href="../../Personnel/user/list_register.php">Utilisateurs</a></li>
                <li><a href="../../Message.php">Message</a></li>
                <li><a href="../../logout.php">Deconnexion</a></li>
            </ul>
        </nav>

<a href='create_cours.php'>ajouter un cours</a>

<h2>Liste des cours</h2>

<?php
// Vérifier si des cours ont été trouvés
if (mysqli_num_rows($resultCours) > 0) {
    // Variable pour suivre le nom de la formation précédente
    $prevFormation = '';

    // Afficher les cours dans un tableau
    echo "<table>
            <tr>
                <th>Formation</th>
                <th colspan='4'>Actions</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultCours)) {
        $idCours = $row['ID'];
        $enseignant = $row['nom_enseignant'];
        $nomCours = $row['nom_cours'];
        $formation = $row['nom_formation'];

        // Vérifier si le nom de la formation est différent du précédent avant de l'afficher
        if ($formation != $prevFormation) {
            echo "<tr>
                    <td>$formation</td>
                    <td><a href='../cours/list_cours.php?nom_formation=$formation'>Les cours de la formation</a></td>
                  </tr>";
        }

        // Mettre à jour la variable du nom de formation précédent
        $prevFormation = $formation;
    }

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>

</body>
</html>
