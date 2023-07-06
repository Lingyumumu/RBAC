<?php
include('../../dbConn.php');
session_start();

if ($_SESSION['role'] != 'professeur') {
    header("location: ../../login.php");
}

$id_etudiant = $_GET['ID'];

// Récupérer les notes avec les informations d'étudiant et de cours associées
$queryNotes = "SELECT notes.ID, notes.note, user.prenom AS etudiant, cours.nom_cours AS cours
               FROM notes
               INNER JOIN user ON notes.id_etudiant = user.ID
               INNER JOIN cours ON notes.id_cours = cours.ID
               WHERE user.ID = '$id_etudiant'"; // Ajouter la condition WHERE avec l'ID de l'étudiant
$resultNotes = mysqli_query($connection, $queryNotes);



// Fermer la connexion à la base de données
mysqli_close($connection);
?>




<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../Administrateur/notes/list_note.css">
    <title>Liste des notes - Administrateur</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }

        footer{
        text-align: center;
        }
    </style>
</head>
<body>
<header>
        <h1>Système de Gestion - EFREI</h1>
    </header>
<nav>
    <ul>
        <li><a href="../Home_Professeur.php">Accueil</a></li>
        <li><a href="list_etudiant_note.php">Notes</a></li>
        <li><a href="../cours_assigner.php">Document</a></li>
        <li><a href="../plannings/list_planning.php">Plannings</a></li>
        <li><a href="../../Message.php">Message</a></li>
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
<h2>Liste des notes</h2>
<a href="create_note.php">Ajouter une note</a><br>


<style>
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding: 5px;
    }
</style>

<?php
// Vérifier si des notes ont été trouvées
if (mysqli_num_rows($resultNotes) > 0) {
    // Afficher les notes dans un tableau
    echo "<table>
            <tr>
                <th>Étudiant</th>
                <th>Cours</th>
                <th>Note</th>
                <th colspan='2'>Actions</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultNotes)) {
        $etudiant = $row['etudiant'];
        $cours = $row['cours'];
        $note = $row['note'];
        $noteID = $row['ID'];

        echo "<tr>
                <td>$etudiant</td>
                <td>$cours</td>
                <td>$note</td>
                <td><a href='edit_note.php?ID=$noteID'>Modifier</a></td>
                <td><a href='delete_note.php?ID=$noteID'>Supprimer</a></td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Aucune note trouvée.";
}
?>
</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>