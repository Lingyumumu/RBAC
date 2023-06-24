<?php
//step1: create a database connection
include('../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom_f = $_POST['txtnomf'];
    $nom_c = $_POST['txtnomc'];
    $prof = $_POST['txtprof'];
    $duree = $_POST['txtduree'];





    
 // Check if user already exists
$querysame = "SELECT * FROM cours WHERE nom_cours = '$nom_c'";
$resultsame = mysqli_query($connection, $querysame);
$count = mysqli_num_rows($resultsame);

 // Check if user already exists
    if ($count > 0) {
        echo "Un cours avec ce nom existe déjà.";
    }
    else {
        $query = "INSERT INTO cours(nom_cours, nom_formation, duree, nom_prof) VALUES('$nom_c','$nom_f','$duree','$prof')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            echo "Creation de cours reussis.";
            echo "<a href='list_cours.php'>Aller à la page principale</a>";
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
    <h2>Ajout cours page</h2>
    <form action='' method='post'>
    Nom du Cours: <input type='text' name='txtnomc' required><br>
    Duree: <input type='text' name='txtduree' required><br>
    Intitule de la formation: <select name='txtnomf' required><br>
        <?php
        $queryf = "SELECT * FROM formations";
        $resultsf = mysqli_query($connection, $queryf);
        while ($row = mysqli_fetch_array($resultsf)) {
            echo "<option value='" . $row['nom'] . "'>" . $row['nom'] . "</option>";
        }
        ?>
    </select><br>
        
    Enseignant assigné: <select name='txtprof' required><br>
        <?php
        $queryp = "SELECT * FROM user WHERE role = 'professeur' ";
        $resultsp = mysqli_query($connection, $queryp);
        while ($row1 = mysqli_fetch_array($resultsp)) {
            echo "<option value='" . $row1['nom'] . "'>" . $row1['nom'] . "</option>";
        }
        ?>
    </select><br>
        
    <input type='submit' name='btnRegister' value='Register'>
</form>

</body>
</html>

