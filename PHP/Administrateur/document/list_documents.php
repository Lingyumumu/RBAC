<?php
include('../../dbConn.php');
session_start();





$id = $_SESSION['ID'];
$role = $_SESSION['role'];
if  ($id == null) {
    header("location: ../../login.php");
}

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


$queryfilter = "SELECT * FROM documents";
$resultfilter = mysqli_query($connection, $queryfilter);   
mysqli_close($connection); 
?>
<h2>Liste des documents</h2>
<html>

<body>
<head>
    <title>Document</title>
</head>

<title>Upload de fichier PDF</title>
    <h2>Uploader un fichier PDF</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="fichier" required>
        <input type="submit" name="btnUpload" value="Uploader">
    </form>


<a href="create_documents.php">Ajouter un document</a>
<table border="1" cellspacing='10'>
        <tr>
            <th>Nom document</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($resultfilter)){
            echo '<tr>';
            echo '<td><a href="download_document.php?ID=' . $row['ID'] . '">' . $row['nom_fichier'] . '</a></td>';
            echo '<td>'. $row['role_expediteur'] . '</td>';
            echo '<td><a href="delete_documents.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
    </body>
    </html>

    

