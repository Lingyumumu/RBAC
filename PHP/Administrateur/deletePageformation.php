<?php 
include '../dbConn.php';
    $formationID = $_GET['ID'];
    
    // Supprimer tous les cours ayant le même nom de formation
    $deleteCoursQuery = "DELETE FROM etude WHERE nom_formation = (SELECT nom_formation FROM etude WHERE ID = $formationID)";
    $resultDeleteCours = mysqli_query($connection, $deleteCoursQuery);
    
    // Supprimer la formation
    $deleteFormationQuery = "DELETE FROM etude WHERE ID = $formationID";
    $resultDeleteFormation = mysqli_query($connection, $deleteFormationQuery);
    
    if($resultDeleteFormation && $resultDeleteCours){
        echo "La formation et les cours associés ont été supprimés avec succès.";
        header("Location: list_formation.php");
    } else {
        echo "Erreur lors de la suppression de la formation et des cours associés.";
    }
/*$id = $_GET['ID'];
$nomf = $_GET['nom_formation'];
$query = "DELETE FROM etude WHERE ID = $id";



if(mysqli_query($connection, $query)){
    $query = "DELETE * FROM etude WHERE nom_formation = '$nomf'";
    header("Location: list_formation.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);

*/




?>


 
