<?php
//step1: create a database connection
include('../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom_f = $_POST['txtnomf'];
    $nom_c = $_POST['txtnomc'];


    
 // Check if user already exists
$querysame = "SELECT * FROM etude WHERE nom_cours = '$nom_c'";
$resultsame = mysqli_query($connection, $querysame);
$count = mysqli_num_rows($resultsame);

 // Check if user already exists
    if ($count > 0) {
        echo "Un cours avec ce nom existe déjà.";
    }
    else {
        $query = "INSERT INTO etude(nom_formation, nom_cours,type) VALUES('$nom_f','$nom_c','cours')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            echo "Creation de cours reussis.";
            echo "<a href='index.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de la création de cours.";
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
    <a href="list_cours.php">liste de formation</a>
    <h2>Registration page</h2>
    <form action='' method='post'>
        Nom du Cours: <input type='text' name='txtnomc' required><br>
        Intitule de la formation: <select type='text' name='txtnomf' required><br>
        <?php
        $queryf = "SELECT * FROM etude WHERE type = 'formation'";
        $resultsf = mysqli_query($connection, $queryf);
        while ($row = mysqli_fetch_array($resultsf)) {
            echo "<option value='" . $row['nom_formation'] . "'>" . $row['nom_formation'] . "</option>";
        }
        ?>
        <input type='submit' name='btnRegister' value='Register'>

    </form>
</body>
</html>
