<?php
include '../../dbConn.php';
session_start();

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
    <
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<header>
        <h1>EFREI - Personnel Administratif</h1>
        <nav>
            <ul>
            <li><a href="Home_Admin.php">Accueil</a></li>
            <li><a href="../Administrateur/notes/list_formation.php">Notes</a></li>
            <li><a href="../Administrateur/cours/list_formation.php">Cours</a></li>
            <li><a href="../Administrateur/formations/list_formation.php">Formations</a></li>
            <li><a href="../Administrateur/document/list_formation.php">document</a></li>
            <li><a href="../Administrateur/plannings/list_formation.php">Planning</a></li>
            <li><a href="../Administrateur/user/list_user.php">Utilisateurs</a></li>
            <li><a href="../Administrateur/user/list_register.php">Inscription</a></li>
            <li><a href="../logout.php">Deconnexion</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
