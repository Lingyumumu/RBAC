
<?php 
include '../dbConn.php';
$formationID = $_GET['ID'];
if ($formationID == null) {
    header("location: list_formation.php");
    exit();
}

// Supprimer tous les cours ayant le même nom de formation
$deleteCoursQuery = "DELETE FROM cours
                    WHERE nom_formation IN (SELECT nom FROM formation WHERE ID = $formationID)";
$resultDeleteCours = mysqli_query($connection, $deleteCoursQuery);

// Supprimer la formation
$deleteFormationQuery = "DELETE FROM formation WHERE ID = $formationID";
$resultDeleteFormation = mysqli_query($connection, $deleteFormationQuery);

if ($resultDeleteFormation && $resultDeleteCours) {
    echo "La formation et les cours associés ont été supprimés avec succès.";
    header("Location: list_formation.php");
    exit();
} else {
    echo "Erreur lors de la suppression de la formation et des cours associés.";
}
?>

