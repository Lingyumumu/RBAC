<?php
session_start();
include('../../dbConn.php');

if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

// Vérifier si l'ID du planning est passé dans l'URL
if (isset($_GET['ID'])) {
    // Récupérer l'ID du planning à supprimer
    $id = $_GET['ID'];

    // Vérifier s'il existe des enregistrements d'absences liés au planning
    $queryAbsences = "SELECT * FROM absences WHERE id_planning = $id";
    $resultAbsences = mysqli_query($connection, $queryAbsences);

    if (mysqli_num_rows($resultAbsences) > 0) {
        // Supprimer les enregistrements d'absences liés au planning
        $deleteAbsencesQuery = "DELETE FROM absences WHERE id_planning = $id";
        $resultDeleteAbsences = mysqli_query($connection, $deleteAbsencesQuery);

        if (!$resultDeleteAbsences) {
            echo "Erreur lors de la suppression des absences : " . mysqli_error($connection);
            exit();
        }
    }

    // Supprimer le planning de la base de données
    $deleteQuery = "DELETE FROM plannings WHERE ID = $id";
    $result = mysqli_query($connection, $deleteQuery);

    if ($result) {
        header("Location: list_formation.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du planning : " . mysqli_error($connection);
    }
} else {
    echo "ID du planning non spécifié.";
}

mysqli_close($connection);
?>
