<?php
//step1: create a database connection
include('../../dbConn.php');



if (isset($_POST['btnRegister'])) {
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
    } else {
        $query = "INSERT INTO cours(nom_cours, nom_formation, duree, nom_prof) VALUES('$nom_c','$nom_f','$duree','')";
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
    <link rel="stylesheet" href="create_cours.css">
</head>

<header>
    <h1>Système de Gestion - EFREI</h1>
</header>

<nav>
        <ul>
            <li><a href="../Home_Admin.php">Accueil</a></li>
            <li><a href="../notes/index_notes.php">Notes</a></li>
            <li><a href="../cours/list_cours.php">Cours</a></li>
            <li><a href="../formations/list_formation.php">Formations</a></li>
            <li><a href="../document/list_documents.php">document</a></li>
            <li><a href="../plannings/list_planning.php">Planning</a></li>
            <li><a href="../user/list_user.php">Utilisateurs</a></li>
            <li><a href="../user/list_register.php">Inscription</a></li>
        </ul>
    </nav>


<body>
    <a href="list_cours.php">liste de cours</a>
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