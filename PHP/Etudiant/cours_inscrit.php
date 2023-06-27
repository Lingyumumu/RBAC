<?php
session_start();
include('../dbConn.php');

// Vérifier si l'utilisateur est connecté avec role professeur, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../login.php');
    exit;
}

$id = $_SESSION['ID'];

$queryUser = "SELECT * FROM user WHERE ID = $id";
$resultUser = mysqli_query($connection, $queryUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$formation = $rowUser['formation'];
$note = $rowUser['note'];

// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT * FROM cours WHERE nom_formation = '$formation' ";
$resultCours = mysqli_query($connection, $queryCours);

// Récupérer les notes avec les informations d'étudiant et de cours associées
$queryNotes = "SELECT notes.note, cours.nom_cours 
               FROM notes
               INNER JOIN cours ON notes.id_cours = cours.ID
               WHERE notes.id_etudiant = $id";
$resultNotes = mysqli_query($connection, $queryNotes);

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
        <li><a href="../Administrateur/Home_Admin.php">Accueil</a></li>
        <li><a href="../Administrateur/notes/index_notes.php">Notes</a></li>
        <li><a href="../Administrateur/cours/index_cours.php">Cours</a></li>
        <li><a href="../Administrateur/formations/index_formations.php">Formations</a></li>
        <li><a href="../Administrateur/salles/index_salles.php">Salles</a></li>
        <li><a href="../Administrateur/plannings/index_plannings.php">Plannings</a></li>
        <li><a href="../Administrateur/absences/index_absences.php">Absences</a></li>
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
                <th>Nom du cours</th>
                <th>Note</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($resultNotes)) {
        $nomCours = $row['nom_cours'];
        $note = $row['note'];

        echo "<tr>
            <td>$nomCours</td>
            <td>$note</td>
          </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>
</body>
</html>
