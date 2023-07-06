<?php
include('../../dbConn.php');
session_start();

if ($_SESSION['role'] != 'etudiant') {
    header("location: ../../login.php");
}
// Récupérer l'identifiant du PDF à télécharger
$documentId = $_GET['ID'];
if (isset($_GET['ID']) == null ){
    header("location: list_documents.php");
}

// Requête pour récupérer les informations du document
$query = "SELECT nom_fichier, type_fichier, taille_fichier, contenu_fichier FROM documents WHERE ID = $documentId";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Récupérer les informations du document
    $nomFichier = $row['nom_fichier'];
    $typeFichier = $row['type_fichier'];
    $tailleFichier = $row['taille_fichier'];
    $contenuFichier = $row['contenu_fichier'];

    // Définir les en-têtes pour le téléchargement
    header("Content-type: $typeFichier");
    header("Content-length: $tailleFichier");
    header("Content-Disposition: attachment; filename=$nomFichier");

    // Afficher le contenu du fichier
    echo $contenuFichier;
} else {
    echo "Erreur lors de la récupération du document depuis la base de données.";
}

mysqli_close($connection);
?>
