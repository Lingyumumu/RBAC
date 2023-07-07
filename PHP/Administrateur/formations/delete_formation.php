<?php
include('../../dbConn.php');
session_start();

if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

$formationID = $_GET['ID'];
if (!isset($_GET['ID'])) {
    header("location: list_formation.php");
    exit();
}

$query = "SELECT * FROM formations WHERE ID = $formationID";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$querycours = "SELECT * FROM cours WHERE nom_formation = '" . $row['nom'] . "'";
$resultcours = mysqli_query($connection, $querycours);
$rowcours = mysqli_fetch_assoc($resultcours);
$id = $rowcours['ID'];

$queryDeleteAbsences = "DELETE FROM absences WHERE id_planning IN (SELECT ID FROM plannings WHERE id_cours = $id)";
if (mysqli_query($connection, $queryDeleteAbsences)) {
    // Supprimer les plannings liés au cours
    $queryDeletePlannings = "DELETE FROM plannings WHERE id_cours = $id";
    if (mysqli_query($connection, $queryDeletePlannings)) {
        // Supprimer les notes liées au cours
        $queryDeleteNotes = "DELETE FROM notes WHERE id_cours = $id";
        if (mysqli_query($connection, $queryDeleteNotes)) {
            // Supprimer le cours
            $queryDeleteCours = "DELETE FROM cours WHERE ID = $id";
            if (mysqli_query($connection, $queryDeleteCours)) {
                $deleteQuery = "DELETE FROM formations WHERE ID = $formationID";
                $resultDelete = mysqli_query($connection, $deleteQuery);
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
} else {
    echo "Erreur lors de la suppression des absences : " . mysqli_error($connection);
}
















$queryDeletePlannings = "DELETE FROM plannings WHERE id_cours = $id";
if (mysqli_query($connection, $queryDeletePlannings)) {
    // Supprimer les notes liées au cours
    $queryDeleteNotes = "DELETE FROM notes WHERE id_cours = $id";
    if (mysqli_query($connection, $queryDeleteNotes)) {
        // Supprimer le cours
        $queryDeleteCours = "DELETE FROM cours WHERE ID = $id";
        if (mysqli_query($connection, $queryDeleteCours)) {
                $deleteQuery = "DELETE FROM formations WHERE ID = $formationID";
                $resultDelete = mysqli_query($connection, $deleteQuery);
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
