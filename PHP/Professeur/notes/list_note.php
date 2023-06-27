<?php
include('../../dbConn.php');

// Récupérer les notes avec les informations d'étudiant et de cours associées
$queryNotes = "SELECT notes.ID, notes.note, user.prenom AS etudiant, cours.nom_cours AS cours
               FROM notes
               INNER JOIN user ON notes.id_etudiant = user.ID
               INNER JOIN cours ON notes.id_cours = cours.ID";
$resultNotes = mysqli_query($connection, $queryNotes);

// Fermer la connexion à la base de données
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des notes - Administrateur</title>
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
                <td><a href='edit_absence.php?ID=$noteID'>Modifier</a></td>
                <td><a href='delete_absence.php?ID=$noteID'>Supprimer</a></td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Aucune note trouvée.";
}
?>
</body>
</html>