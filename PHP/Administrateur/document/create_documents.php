<?php
session_start();
include('dbConn.php');
$id = $_SESSION['ID'];
$role = $_SESSION['role'];

if (isset($_POST['btnUpload'])) {
    $nomFichier = $_FILES['fichier']['name'];
    $typeFichier = $_FILES['fichier']['type'];
    $tailleFichier = $_FILES['fichier']['size'];
    $contenuFichier = mysqli_real_escape_string($connection, file_get_contents($_FILES['fichier']['tmp_name']));

    // Requête d'insertion du fichier dans la base de données
    $query = "INSERT INTO documents (nom_fichier, type_fichier, taille_fichier, contenu_fichier,ID_expediteur,role_expediteur) VALUES ('$nomFichier', '$typeFichier', '$tailleFichier', '$contenuFichier','$id','$role')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Le fichier a été inséré avec succès dans la base de données.<br>";
        echo '<a href="list_documents.php">Ajouter un document</a>';

    } else {
        echo "Erreur lors de l'insertion du fichier dans la base de données: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload de fichier PDF</title>
</head>
<body>
    <h2>Uploader un fichier PDF</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="fichier" required>
        <input type="submit" name="btnUpload" value="Uploader">
    </form>
</body>
</html>
