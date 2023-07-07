<?php
session_start();
include('../../dbConn.php');
$id = $_GET['ID'];

// Supprimer les plannings liés au cours
$queryDeletePlannings = "DELETE FROM plannings WHERE id_cours = $id";
if (mysqli_query($connection, $queryDeletePlannings)) {
    // Supprimer les notes liées au cours
    $queryDeleteNotes = "DELETE FROM notes WHERE id_cours = $id";
    if (mysqli_query($connection, $queryDeleteNotes)) {
        // Supprimer le cours
        $queryDeleteCours = "DELETE FROM cours WHERE ID = $id";
        if (mysqli_query($connection, $queryDeleteCours)) {
            header("Location: list_formation.php");
        } else {
            echo "Erreur lors de la suppression du cours : " . mysqli_error($connection);
        }
    } else {
        echo "Erreur lors de la suppression des notes : " . mysqli_error($connection);
    }
} else {
    echo "Erreur lors de la suppression des plannings : " . mysqli_error($connection);
}

mysqli_close($connection);
?>
