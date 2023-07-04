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
    <
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<header>
        <h1>EFREI - Personnel Administratif</h1>
        <nav>
            <ul>
                <li><a href="../Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="../Personnel/cours/list_cours.php">Cours</a></li>
                <li><a href="../Personnel/plannings/index_plannings.php">¨Planning</a></li>
                <li><a href="../Personnel/notes/list_notes.php">Notes</a></li>
                <li><a href="../Personnel/user/list_user.php">Utilisateurs</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
