<?php
include '../../dbConn.php';

if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
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
        <h1>EFREI - Personnel Administratif</h1>
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
    </header>
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