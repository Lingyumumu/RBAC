<?php
//step1: create a database connection
include('../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $vide = "";




 // Check if user already exists
 $querysame = "SELECT * FROM etude WHERE nom_formation = '$nom'";
 $resultsame = mysqli_query($connection, $querysame);
 $count = mysqli_num_rows($resultsame);
 
  // Check if user already exists
    if ($count > 0) {
        echo "Un compte avec cet email existe déjà.";
    }
    else {
        $query = "INSERT INTO etude (nom_formation,nom_cours,type) VALUES('$nom','$vide','formation')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            echo "Création de fomation.";
            echo "<a href='list_formation.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de la création de fomation.";
        }
}
}



?>


<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>

<body>
    <a href="list_formation.php">liste de formation</a>
    <h2>Ajout Formation</h2>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' required><br>
        <input type='submit' name='btnRegister' value='Register'>
    </form>
</body>
</html>

