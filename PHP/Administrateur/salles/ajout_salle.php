<?php
//step1: create a database connection
include('../../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $capacite = $_POST['txtcapacite'];




 // Check if user already exists
 $querysame = "SELECT * FROM salles WHERE nom = '$nom'";
 $resultsame = mysqli_query($connection, $querysame);
 $count = mysqli_num_rows($resultsame);
 
  // Check if user already exists
    if ($count > 0) {
        echo "Une salle avec le même nom a été déjà créee.";
    }
    else {
        $query = "INSERT INTO salles (nom,capacite) VALUES('$nom','$capacite')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            echo "La salle a été bien ajouté.";
            echo "<a href='list_salle.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de la création de salle.";
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
    <a href="list_formation.php">liste de salle</a>
    <h2>Ajout Salle</h2>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' required><br>
        Capacité: <input type='text' name='txtcapacite' required><br>
        <input type='submit' name='btnRegister' value='Register'>
    </form>
</body>
</html>

