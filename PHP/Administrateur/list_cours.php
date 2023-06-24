<?php
//step1: create a database connection
include ('../dbConn.php');
// Exécuter la requête avec la clause WHERE appropriée
        $query = "SELECT * FROM cours";
        $results = mysqli_query($connection, $query);      
    //step3: execute the query

    ?>
    <a href="ajout_cours.php">Ajouter un cours</a>
    <table border="1" cellspacing='10'>
        <tr>
            <th>ID</th>
            <th>Nom Formation</th>
            <th>Nom Cours</th>
            <th>Nom Professeur</th>
            <th>Durée</th>

        </tr>
        <?php while($row = mysqli_fetch_assoc($results)){
            echo '<tr>';
            echo '<td>'. $row['ID'] . '</td>';
            echo '<td>'. $row['nom_formation'] . '</td>';
            echo '<td>' . $row['nom_cours'] . '</td>';
            echo '<td>' . $row['nom_prof'] . '</td>';
            echo '<td>' . $row['duree'] . '</td>';
            echo '<td><a href="editPagecours.php?ID=' . $row['ID'] . '">Modifier</a></td>';
            echo '<td><a href="deletePagecours.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
    </body>
    </html>