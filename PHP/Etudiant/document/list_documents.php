<?php
include('../../dbConn.php');
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../../login.php');
}
$id = $_SESSION['id'];
$query = "SELECT * FROM documents WHERE ID_expediteur = $id AND role_expediteur = 'administateur'OR role_expediteur = 'professeur' OR role_expediteur = 'personnel''";
$results = mysqli_query($connection, $query);    
?>
<h2>Liste des documents</h2>
<html>

<body>
<head>
    <title>Document</title>
</head>
<a href="create_documents.php">Ajouter un document</a>
<table border="1" cellspacing='10'>
        <tr>
            <th>Nom document</th>
            <th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($results)){
            echo '<tr>';
            echo '<td><a href="downloaddocument.php?id=' . $row['ID'] . '">' . $row['nom_fichier'] . '</a></td>';
            echo '<td><a href="deletePagedocuments.php?id=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
    </body>
    </html>

