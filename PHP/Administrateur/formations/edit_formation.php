<?php
include ('../../dbConn.php');
if (isset($_GET['ID']) == null ){
    header("location: list_formation.php");
}
$id = $_GET['ID'];
// Récupérer l'ancien nom de formation
/*
if (isset($_POST['btnUpdate'])){
    $nom = $_POST['txtnom'];

    $updateQuery = "UPDATE etude SET nom_formation = $nom WHERE (SELECT nom_formation FROM etude WHERE ID = $id)";
    $resultQuery = mysqli_query($connection, $updateQuery);

    $MFormationQuery = "UPDATE etude SET nom_formation = $nom WHERE ID = $id";
    $resultMFormation = mysqli_query($connection, $MFormationQuery);

    if($resultQuery && $resultMFormation){
        echo "the user has been updated<br>";
        header("Location: list_formation.php");
        // Mettre à jour le nom_formation dans la table cours
        // Valider la transaction
        mysqli_commit($connection);

    }
    else{
        echo "the user has not been updated<br>";
    }
}*/

$queryOldValue = "SELECT nom FROM formations WHERE ID = $id";
$resultOldValue = mysqli_query($connection, $queryOldValue);
$rowOldValue = mysqli_fetch_assoc($resultOldValue);
$oldValue = $rowOldValue['nom'];

if (isset($_POST['btnUpdate'])) {
    $nom = $_POST['txtnom'];
    $etude = $_POST['txtniveau_etude'];
    $duree = $_POST['txtduree'];

    // Mettre à jour le nom de formation dans la table etude
    $updateQuery = "UPDATE formations SET nom = '$nom', niveau = '$etude', duree = '$duree'  WHERE ID = $id";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if ($resultQuery) {
        echo "La formation a été mise à jour avec succès.<br>";

        // Mettre à jour le meme nom de formation dans la table etude dont le type est cours qui est associé à la formation
        $updateCoursQuery = "UPDATE cours SET nom_formation = '$nom' WHERE nom_formation = '$oldValue'";
        $resultUpdateCours = mysqli_query($connection, $updateCoursQuery);
        
        if ($resultUpdateCours) {
            echo "Les cours associés ont été mis à jour avec succès.";
            header("Location: list_formation.php");
        } else {
            echo "Erreur lors de la mise à jour des cours associés.";
        }
    } else {
        echo "Erreur lors de la mise à jour de la formation.";
    }
}


$query = "SELECT * FROM formations WHERE ID = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="edit_formation.css" rel="stylesheet" type="text/css"/>
</head>

<header>
    <h1>Système de Gestion - EFREI</h1>
</header>

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

<body>
    <h1>Page de modification</h1>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' value="<?php echo $row['nom'] ?>" required><br>
        Durée: <input type='text' name='txtduree' value="<?php echo $row['duree'] ?>" required><br>
        niveau etude: <select name='txtniveau_etude'>
            <option value='<?php echo $row['niveau'] ?>'><?php echo $row['niveau'] ?></option>
            <option value='BAC+1'>BAC+1</option>
            <option value='BAC+2'>BAC+2</option>
            <option value='BAC+3'>BAC+3</option>
            <option value='BAC+4'>BAC+4</option>
            <option value='BAC+5'>BAC+5</option>
            <option value='BAC+6'>BAC+6</option>
            <option value='BAC+7'>BAC+7</option>
        </select><br>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='list_formation.php'>Aller à la liste formation</a>
    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>
</html>

