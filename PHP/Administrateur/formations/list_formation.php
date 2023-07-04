<?php

//step1: create a database connection
include('../../dbConn.php');
// Exécuter la requête avec la clause WHERE appropriée
$query = "SELECT * FROM formations";
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
        <link rel="stylesheet" href="list_formation.css">
    </head>

    <header>
        <h1>Système de Gestion - EFREI</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../Home_Admin.php">Accueil</a></li>
            <li><a href="../notes/index_notes.php">Notes</a></li>
            <li><a href="../cours/list_cours.php">Cours</a></li>
            <li><a href="list_formation.php">Formations</a></li>
            <li><a href="../documents/list_documents.php">document</a></li>
            <li><a href="../plannings/list_planning.php">Planning</a></li>
            <li><a href="../user/list_user.php">Utilisateurs</a></li>
            <li><a href="../user/list_register.php">Inscription</a></li>
        </ul>
    </nav>

    <table border="1" cellspacing='10'>
        <a href="create_formation.php">Ajouter une formation</a>
        <tr>
            <th>Nom de Formation</th>
            <th>Niveau</th>
            <th>Durée</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)) {
            echo '<tr>';
            echo '<td>' . $row['nom'] . '</td>';
            echo '<td>' . $row['niveau'] . '</td>';
            echo '<td>' . $row['duree'] . '</td>';
            echo '<td><a href="edit_formation.php?ID=' . $row['ID'] . '">Modifier</a></td>';
            echo '<td><a href="delete_formation.php?ID=' . $row['ID'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
        ?>
    </table>
    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>
</html>