
<?php
session_start();
include '../../dbConn.php';
if ($_SESSION['role'] != 'etudiant') {
    header("location: ../../login.php");
}
if (isset($_GET['ID']) == null ){
    header("location: list_documents.php");
}
// Vérifier si l'ID du document est présent dans la requête GET
$id = $_GET['ID'];

    // Requête de suppression du document dans la base de données
$query = "DELETE FROM documents WHERE ID = $id";

if (mysqli_query($connection, $query)) {
    // Rediriger vers la page de liste des documents après la suppression réussie
    header("Location: list_documents.php");
    exit;
} 
else{
        echo "Erreur lors de la suppression du document : " . mysqli_error($connection);
}

mysqli_close($connection);
?>