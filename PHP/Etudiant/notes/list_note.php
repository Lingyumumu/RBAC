<?php
include('../../dbConn.php');
//Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../login.php');
    exit;
}
$id = $_SESSION['ID'];

// Récupérer les notes avec les informations d'étudiant et de cours associées pour l'ID de l'utilisateur connecté
$queryNotes = "SELECT notes.ID, notes.note, user.prenom AS etudiant, cours.nom_cours AS cours
               FROM notes
               INNER JOIN user ON notes.id_etudiant = user.ID
               INNER JOIN cours ON notes.id_cours = cours.ID
               WHERE user.ID = '$id'";

$resultNotes = mysqli_query($connection, $queryNotes);

// Fermer la connexion à la base de données
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes notes</title>
    <link rel="stylesheet" href="list_note.css">
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
<header>
    <h1>Système de gestion de l'EFREI</h1>
</header>

<nav>
    <ul>
        <li><a href="../Home_Etudiant.php">Accueil</a></li>
        <li><a href="../plannings/list_planning.php">Mon emploi-du-temps</a></li>
        <li><a href="../cours_inscrit.php">Cours</a></li>
        <li><a href="../notes/list_note.php">Mes notes</a></li>
        <?php echo '<li><td><a href="../mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
        <li><a href="../../logout.php">Deconnexion</a></li>
        
    </ul>
</nav>

<style>
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding: 5px;
    }
</style>
<h2>Mes notes</h2>

<?php
// Vérifier si des notes ont été trouvées
if (mysqli_num_rows($resultNotes) > 0) {
    // Afficher les notes dans un tableau
    echo "<table>
            <tr>
                <th>Cours</th>
                <th>Note</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultNotes)) {
        $etudiant = $row['etudiant'];
        $cours = $row['cours'];
        $note = $row['note'];
        $noteID = $row['ID'];

        echo "<tr>
                <td>$cours</td>
                <td>$note</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Aucune note trouvée.";
}
?>
</body>
</html>
