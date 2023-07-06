<?php
include('../../dbConn.php');
session_start();


$id_cours = $_GET['ID'] ;
$id = $_SESSION['ID'];
$role = $_SESSION['role'];
if ($_SESSION['role'] != 'professeur') {
    header("location: ../../login.php");
}






$queryCourse = "SELECT * FROM cours WHERE ID = '$id_cours'";
$resultCourse = mysqli_query($connection, $queryCourse);
$rowCourse = mysqli_fetch_assoc($resultCourse);




if (isset($_POST['btnUpload'])) {
    $nomFichier = $_FILES['fichier']['name'];
    $typeFichier = $_FILES['fichier']['type'];
    $tailleFichier = $_FILES['fichier']['size'];
    $contenuFichier = mysqli_real_escape_string($connection, file_get_contents($_FILES['fichier']['tmp_name']));

    // Requête d'insertion du fichier dans la base de données
    $query = "INSERT INTO documents (nom_fichier, type_fichier, taille_fichier, contenu_fichier,ID_expediteur,role_expediteur,ID_cours, date)
     VALUES ('$nomFichier', '$typeFichier', '$tailleFichier', '$contenuFichier','$id','$role',$id_cours, NOW())";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Le fichier a été inséré avec succès dans la base de données.<br>";
        echo '<a href="list_documents.php">Ajouter un document</a>';

    } else {
        echo "Erreur lors de l'insertion du fichier dans la base de données: " . mysqli_error($connection);
    }
}


$queryfilter = "SELECT * FROM documents where ID_cours = '$id_cours' AND role_expediteur = 'professeur' ";
$resultfilter = mysqli_query($connection, $queryfilter);   
 


?>
<h2>Liste des documents</h2>
<html>

<body>
<head>
    <link rel="stylesheet" href="../../Administrateur/document/list_documents.css">
    <title>Document</title>
</head>

<header>
        <h1>Système de Gestion - EFREI</h1>
    </header>
<nav>
    <ul>
        <li><a href="../Home_Professeur.php">Accueil</a></li>
        <li><a href="../Professeur/notes/list_etudiant_note.php">Notes</a></li>
        <li><a href="../document/list_documents.php">Documents</a></li>
        <li><a href="../plannings/list_planning.php">Plannings</a></li>
        <li><a href="../../Message.php">Message</a></li>
        <li><a href="../../logout.php">Deconnexion</a></li>
    </ul>
</nav>

<title>Upload de fichier PDF</title>
    <h2>Voir les devoir deposer dans <?php echo $rowCourse['nom_cours'];  ?>
    </h2>



<a href="create_documents.php">Ajouter un document</a>
<table border="1" cellspacing='10'>
        <tr>
            <th>Nom document</th>
            <th>Date</th>

        </tr>
        <?php while($row = mysqli_fetch_assoc($resultfilter)){
            echo '<tr>';
            echo '<td><a href="download_documents.php?ID=' . $row['ID'] . '">' . $row['nom_fichier'] . '</a></td>';
            echo '<td>' . $row['date'] . '</td>';

            echo '</tr>';
        }
    ?>
    </table>
    
    </body>

    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

    </html>

    
