<?php
include('../../dbConn.php');

$id_etudiant = $_GET['ID'];

// Récupérer les notes avec les informations d'étudiant et de cours associées
$queryNotes = "SELECT notes.ID, notes.note, user.prenom AS etudiant, cours.nom_cours AS cours
               FROM notes
               INNER JOIN user ON notes.id_etudiant = user.ID
               INNER JOIN cours ON notes.id_cours = cours.ID
               WHERE user.ID = '$id_etudiant'"; // Ajouter la condition WHERE avec l'ID de l'étudiant
$resultNotes = mysqli_query($connection, $queryNotes);

// Filtres
$filterCours = isset($_GET['cours']) ? $_GET['cours'] : '';
$filterNote = isset($_GET['note']) ? $_GET['note'] : '';
$filterEtudiant = isset($_GET['etudiant']) ? $_GET['etudiant'] : '';

if (!empty($filterCours)) {
    $queryNotes .= " WHERE cours.nom_cours LIKE '%$filterCours%'";
}

if (!empty($filterNote)) {
    if (!empty($filterCours)) {
        $queryNotes .= " AND notes.note = '$filterNote'";
    } else {
        $queryNotes .= " WHERE notes.note = '$filterNote'";
    }
}

if (!empty($filterEtudiant)) {
    if (!empty($filterCours) || !empty($filterNote)) {
        $queryNotes .= " AND user.prenom LIKE '%$filterEtudiant%'";
    } else {
        $queryNotes .= " WHERE user.prenom LIKE '%$filterEtudiant%'";
    }
}

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
    </style>
</head>
<body>
<header>
        <h1>Système de Gestion - EFREI</h1>
    </header>
<nav>
    <ul>
        <li><a href="../Home_Professeur.php">Accueil</a></li>
        <li><a href="../notes/list_note.php">Notes</a></li>
        <li><a href="../cours_assigner.php">Document</a></li>
        <li><a href="../plannings/list_planning.php">Plannings</a></li>
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

<form action="" method="GET">
    <label for="cours">Cours :</label>
    <input type="text" name="cours" id="cours" value="<?php echo $filterCours; ?>">

    <label for="note">Note :</label>
    <input type="text" name="note" id="note" value="<?php echo $filterNote; ?>">

    <label for="etudiant">Étudiant :</label>
    <input type="text" name="etudiant" id="etudiant" value="<?php echo $filterEtudiant; ?>">

    <input type="submit" value="Filtrer">
</form>

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