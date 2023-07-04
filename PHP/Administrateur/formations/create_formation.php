<?php
//step1: create a database connection
include('../../dbConn.php');



if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $niveau_etude = $_POST['txtniveau_etude'];
    $duree = $_POST['txtduree'];




 // Check if user already exists
 $querysame = "SELECT * FROM formations WHERE nom = '$nom'";
 $resultsame = mysqli_query($connection, $querysame);
 $count = mysqli_num_rows($resultsame);
 
  // Check if user already exists
    if ($count > 0) {
        echo "Une formation similaire a deja ete creer.";
    }
    else {
        $query = "INSERT INTO formations (nom,niveau,duree) VALUES('$nom','$niveau_etude','$duree')";
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
    <link rel="stylesheet" href="create_formation.css">
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

<body>
    <a href="list_formation.php">liste de formation</a>
    <h2>Ajout Formation</h2>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' required><br>
        duree: <input type='text' name='txtduree' required><br>
        niveau etude: <select name='txtniveau_etude'>
            <option value='BAC+1'>1</option>
            <option value='BAC+2'>2</option>
            <option value='BAC+3'>3</option>
            <option value='BAC+4'>4</option>
            <option value='BAC+5'>5</option>
            <option value='BAC+6'>6</option>
            <option value='BAC+7'>7</option>
        </select><br>
        <input type='submit' name='btnRegister' value='Register'>
    </form>
    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>
</html>

