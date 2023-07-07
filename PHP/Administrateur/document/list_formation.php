<?php
include('../../dbConn.php');
session_start();

if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}
// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT * From formations ";
                


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
<h1>EFREI - Administrateur</h1>
        <nav>
            <ul>
            <li><a href="../../Administrateur/Home_Admin.php">Accueil</a></li>
            <li><a href="../../Administrateur/notes/list_formation.php">Notes</a></li>
            <li><a href="../../Administrateur/cours/list_formation.php">Cours</a></li>
            <li><a href="../../Administrateur/formations/list_formation.php">Formations</a></li>
            <li><a href="../../Administrateur/document/list_formation.php">document</a></li>
            <li><a href="../../Administrateur/plannings/list_formation.php">Planning</a></li>
            <li><a href="../../Administrateur/user/list_user.php">Utilisateurs</a></li>
            <li><a href="../../Administrateur/user/list_register.php">Inscription</a></li>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../../logout.php">Deconnexion</a></li>
            </ul>
        </nav>

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

        $formation = $row['nom'];

        // Vérifier si le nom de la formation est différent du précédent avant de l'afficher
        if ($formation != $prevFormation) {
            echo "<tr>
                    <td>$formation</td>
                    <td><a href='../document/cours_assigner.php?nom_formation=$formation'>Les cours de la formation</a></td>
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
<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</html>
