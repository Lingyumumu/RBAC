<?php 
include ('../../dbConn.php');
    $formationID = $_GET['ID'];
    if (isset($_GET['ID']) == null ){
        header("location: list_formation.php");
    }
    

    $query = "SELECT * FROM formations WHERE ID = $formationID";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

echo $row['nom'];

$deleteQuery = "DELETE FROM cours WHERE nom_formation = '" . $row['nom'] . "'";
$resultDelete = mysqli_query($connection, $deleteQuery);

$deleteQuery = "DELETE FROM formations WHERE ID = $formationID";
$resultDelete = mysqli_query($connection, $deleteQuery);


if ($resultDelete && $resultDelete) {
    echo "La formation a été supprimée avec succès.<br>";
    header("Location: list_formation.php");
} else {
    echo "Erreur lors de la suppression de la formation.";
}
?>
