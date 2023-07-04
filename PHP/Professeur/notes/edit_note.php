<?php
include '../../dbConn.php';
session_start();
if ($_SESSION['role'] != 'professeur') {
    header("location: ../../login.php");
}

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
    <link rel="stylesheet" href="../../Administrateur/notes/edit_note.css">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<header>
        <h1>Système de Gestion - EFREI</h1>
    </header>
<nav>
    <ul>
        <li><a href="../Home_Professeur.php">Accueil</a></li>
        <li><a href="../notes/list_note.php">Notes</a></li>
        <li><a href="../document/list_documents.php">Documents</a></li>
        <li><a href="../plannings/list_planning.php">Plannings</a></li>
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