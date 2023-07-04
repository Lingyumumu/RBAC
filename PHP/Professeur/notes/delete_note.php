<?php
include '../../dbConn.php';

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $query = "DELETE FROM notes WHERE ID = $id";
    if (mysqli_query($connection, $query)) {
        header("Location: delete_note.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} else {
    echo "ID not specified.";
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
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
</body>
</html>
