<?php
include '../../dbConn.php';

if (isset($_GET['ID']) == null) {
    header("location: edit_note.php");
    exit();
}

$id = $_GET['ID'];

$queryOldValue = "SELECT note FROM notes WHERE ID = $id";
$resultOldValue = mysqli_query($connection, $queryOldValue);
$rowOldValue = mysqli_fetch_assoc($resultOldValue);
$oldNom = $rowOldValue['note'];

if (isset($_POST['btnUpdate'])) {
    $note = $_POST['txtnote'];

    // Mettre à jour la note
    $updateQuery = "UPDATE notes SET note = '$note' WHERE ID = $id";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if ($resultQuery) {
        echo "La note a été mise à jour avec succès.<br>";
    }
}

$query = "SELECT * FROM notes WHERE ID = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<nav>
    <ul>
        <li><a href="../Home_Admin.php">Accueil</a></li>
        <li><a href="index_notes.php">Notes</a></li>
        <li><a href="../cours/index_cours.php">Cours</a></li>
        <li><a href="../formations/index_formations.php">Formations</a></li>
        <li><a href="../index_salles.php">Salles</a></li>
        <li><a href="../plannings/index_plannings.php">Plannings</a></li>
        <li><a href="../absences/index_absences.php">Absences</a></li>
        <li><a href="etudiants.html">Étudiants</a></li>
        <li><a href="enseignants.html">Enseignants</a></li>
        <li><a href="utilisateurs.html">Utilisateurs</a></li>
        <li><a href="configurations.html">Configurations</a></li>
        <li><a href="securite.html">Sécurité</a></li>
    </ul>
</nav>
<a href="list_note.php">Liste des notes</a>
<h1>Page de modification</h1>
<form action='' method='post'>
    Note: <input type='text' name='txtnote' value="<?php echo $row['note'] ?>" required><br>
    <br><br>
    <input type='submit' name='btnUpdate' value='Mettre à jour'>
</form>
<br><br>
</body>
</html>