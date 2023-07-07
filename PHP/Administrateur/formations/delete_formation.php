<?php 
include ('../../dbConn.php');
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
$id_cours = $rowcours['ID'];


$queryDeletePlannings = "DELETE FROM plannings WHERE id_cours = $id_cours";
if (mysqli_query($connection, $queryDeletePlannings)) {
    $queryDeleteNotes = "DELETE FROM notes WHERE id_cours = $id_cours";
    if (mysqli_query($connection, $queryDeleteNotes)) {
        $deleteQuery = "DELETE FROM cours WHERE nom_formation = '$row[nom]'";
        $resultDelete = mysqli_query($connection, $deleteQuery);

        
        

        if ($resultDelete) {
            $updateQuery = "UPDATE user SET formation = '' WHERE formation = '$row[nom]'";
            $resultUpdate = mysqli_query($connection, $updateQuery);

            if ($resultUpdate) {
                $deleteQuery = "DELETE FROM formations WHERE ID = $formationID";
                $resultDelete = mysqli_query($connection, $deleteQuery);
                echo "Les utilisateurs ont été mis à jour.<br>";
                echo "La formation a été supprimée avec succès.<br>";
                header("Location: list_formation.php");
            exit();
            } else {
                echo "Erreur lors de la mise à jour des utilisateurs.<br>";
            }
            
            
        } else {
            echo "Erreur lors de la suppression de la formation.";
        }
    } else {
        echo "Erreur lors de la suppression des notes : " . mysqli_error($connection);
    }
} else {
    echo "Erreur lors de la suppression des plannings : " . mysqli_error($connection);
}

mysqli_close($connection);
?>
