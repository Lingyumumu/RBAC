<?php
include('../../dbConn.php');

// Vérifier si l'ID du planning est passé dans l'URL


// Récupérer l'ID du planning à supprimer
$id = $_GET['ID'];

// Supprimer le planning de la base de données
$deleteQuery = "DELETE FROM plannings WHERE ID = $id";
$result = mysqli_query($connection, $deleteQuery);

if ($result) {
    header("Location: list_planning.php");
    exit();
} else {
    echo "Erreur lors de la suppression du planning.";
}
?>