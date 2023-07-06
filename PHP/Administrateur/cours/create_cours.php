<?php
//step1: create a database connection
include('../../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom_f = $_POST['txtnomf'];
    $nom_c = $_POST['txtnomc'];
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
        $query = "INSERT INTO cours(nom_cours, nom_formation, duree, nom_prof) VALUES('$nom_c','$nom_f','$duree','')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            echo "Creation de cours reussis.";
            echo "<a href='list_formation.php'>Aller a la page de cours</a>";
        } else {
            echo "Échec de la création de cours.";
        }
    }
}


?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../Administrateur/cours/create_cours.css">
    <title>Document</title>
</head>

<body>
    <h1>EFREI - Administrateur</h1>
        <nav>
            <ul>
            <li><a href="../../Administrateur/Home_Admin.php">Accueil</a></li>
            <li><a href="../../Administrateur/notes/list_formation.php">Notes</a></li>
            <li><a href="../../Administrateur/cours/list_formation.php">Cours</a></li>
            <li><a href="../../Administrateur/formations/list_formation.php">Formations</a></li>
            <li><a href="../../Administrateur/document/list_formation.php">document</a></li>
            <li><a href="../../Administrateur/plannings/list_formation.php">Planning</a></li>
            <li><a href="../../Administrateur/user/list_user.php">Utilisateurs</a></li>
            <li><a href="../../Administrateur/user/list_register.php">Inscription</a></li>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../../logout.php">Deconnexion</a></li>
            </ul>
        </nav>
    <a href="list_formation.php">liste de cours</a>
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
        
    <input type='submit' name='btnRegister' value='Register'>
</form>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</body>
</html>

