<?php

//step1: create a database connection
include ('../dbConn.php');
// Exécuter la requête avec la clause WHERE appropriée
        $query = "SELECT * FROM etude WHERE type = 'formation'";
        $results = mysqli_query($connection, $query);      
    //step3: execute the query
    /*
    if(isset($_POST['btnDelete'])){
        $formationID = $_POST['formationID'];
        
        // Supprimer tous les cours ayant le même nom de formation
        $deleteCoursQuery = "DELETE FROM etude WHERE nom_formation = (SELECT nom_formation FROM etude WHERE ID = $formationID)";
        $resultDeleteCours = mysqli_query($connection, $deleteCoursQuery);
        
        // Supprimer la formation
        $deleteFormationQuery = "DELETE FROM etude WHERE ID = $formationID";
        $resultDeleteFormation = mysqli_query($connection, $deleteFormationQuery);
        
        if($resultDeleteFormation && $resultDeleteCours){
            echo "La formation et les cours associés ont été supprimés avec succès.";
            header("Location: list_formation.php");
        } else {
            echo "Erreur lors de la suppression de la formation et des cours associés.";
        }}
*/
    ?>
    
    <html>

    <body>
    <head>
        <title>Document</title>

    <table border="1" cellspacing='10'>
        <a href="ajout_formation.php">Ajouter une formation</a>
        <tr>
            <th>Nom de Formation</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($results)){
            echo '<tr>';
            echo '<td>' . $row['nom_formation'] . '</td>';
            /*echo '<td>
                <form action="" method="post">
                    <input type="hidden" name="formationID" value="' . $row['ID'] . '">
                    <input type="submit" name="btnDelete" value="Supprimer la formation">
                </form>
            </td>';*/
            echo '<td><a href="editPageformation.php?ID=' . $row['ID'] . '">Modifier</a></td>';
            echo '<td><a href="deletePageformation.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
</body>
</html>

