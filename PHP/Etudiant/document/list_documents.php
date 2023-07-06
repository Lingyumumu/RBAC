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


$queryfilter = "SELECT * FROM documents where ID_expediteur = '$id' ";
$resultfilter = mysqli_query($connection, $queryfilter);   
 

$queryfilter2 = "SELECT * FROM user where ID = '$id'";
$resultfilter2 = mysqli_query($connection, $queryfilter2);
$row2 = mysqli_fetch_assoc($resultfilter2);

$queryfilter3 = "SELECT * FROM documents where role_expediteur = 'professeur' ";
$resultfilter3 = mysqli_query($connection, $queryfilter3);
$row3 = mysqli_fetch_assoc($resultfilter3);
?>
<h2>Liste des documents</h2>
<html>

<body>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="list_documents.css">
</head>

<header>
<h1>Système de Gestion de l'EFREI</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../Home_Etudiant.css">Accueil</a></li>
            <li><a href="../plannings/index_plannings.php">Mon emploi-du-temps</a></li>
            <li><a href="../notes/list_note.php">Mes notes</a></li>
            <li><a href="../cours_inscrit.php">Cours</a></li>
            <?php echo '<li><td><a href="../mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../../logout.php">Deconnexion</a></li>
        </ul>
    </nav>

<title>Upload de fichier PDF</title>
<h2>Sujet de Devoir</h2>
<table border="1" cellspacing='10'>
        <tr>
            <th>Nom document</th>
            <th>Nom expediteur</th>
        </tr>
        <?php while($row3 = mysqli_fetch_assoc($resultfilter3)){
            echo '<tr>';
            echo '<td><a href="download_documents.php?ID=' . $row3['ID'] . '">' . $row3['nom_fichier'] . '</a></td>';
            echo '<td>' . $row2['nom'] . '</td>';
            echo '</tr>';
        }
    ?>
</table>

<h2>Devoir rendu</h2>
<table border="1" cellspacing='10'>
    <tr>
        <th>Nom document</th>
        <th>Nom expediteur</th>
        <th>Supprimer</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($resultfilter)){
        echo '<tr>';
        echo '<td><a href="download_documents.php?ID=' . $row['ID'] . '">' . $row['nom_fichier'] . '</a></td>';
        echo '<td>' . $row2['nom'] . '</td>';
        echo '<td><a href="delete_documents.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
        echo '</tr>';
        }
    ?>
</table>

<br>
<h2>Envoyer un devoir sous format PDF</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="fichier" required>
    <input type="submit" name="btnUpload" value="Uploader">
</form>


</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>

    

