<?php
session_start();
include('../dbConn.php');

// Vérifier si l'utilisateur est connecté avec role professeur, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professeur') {
    header('Location: ../login.php');
    exit;
}

$id = $_SESSION['ID'];



// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT * FROM cours WHERE ID = $id";
$resultCours = mysqli_query($connection, $queryCours);

// Fermer la connexion à la base de données
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<header>
    <h1>Système de Gestion - EFREI</h1>
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
                <th>Nom du cours</th>
                <th>Formation</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultCours)) {
        $idCours = $row['ID'];
        $nomCours = $row['nom_cours'];
        $formation = $row['nom_formation'];

        echo "<tr>
                <td>$idCours</td>
                <td>$nomCours</td>
                <td>$formation</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>

</body>
</html>
