<?php
include ('../../dbConn.php');
if (isset($_GET['ID']) == null ){
    header("location: list_salle.php");
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

$queryOldValue = "SELECT nom FROM salles WHERE ID = $id";
$resultOldValue = mysqli_query($connection, $queryOldValue);
$rowOldValue = mysqli_fetch_assoc($resultOldValue);
$oldValue = $rowOldValue['nom'];

if (isset($_POST['btnUpdate'])) {
    $nom = $_POST['txtnom'];

    // Mettre à jour le nom de la salle dans la table
    $updateQuery = "UPDATE salles SET nom = '$nom' WHERE ID = $id";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if ($resultQuery) {
        echo "La salle a été mise à jour avec succès.<br>";

    }
}

$query = "SELECT * FROM salles WHERE ID = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h1>Page de modification</h1>
    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' value="<?php echo $row['nom'] ?>" required><br>
        Capacité: <input type='text' name='txtcapacite' value="<?php echo $row['capacite'] ?>" required><br>

        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='list_salle.php'>Aller à la liste salle</a>
</body>
</html>