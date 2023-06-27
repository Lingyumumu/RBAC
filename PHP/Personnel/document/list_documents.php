<?php
include('dbConn.php');
$query = "SELECT * FROM documents";
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

