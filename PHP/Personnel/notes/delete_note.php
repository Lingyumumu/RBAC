<?php
include '../../dbConn.php';
session_start();
if ($_SESSION['role'] != 'personnel') {
    header("location: ../../login.php");
}

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    $query = "DELETE FROM notes WHERE ID = $id";
    if (mysqli_query($connection, $query)) {
        header("Location: list_formation.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} else {
    echo "ID not specified.";
}

mysqli_close($connection);
?>


