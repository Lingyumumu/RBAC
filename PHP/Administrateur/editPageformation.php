<?php
include '../dbConn.php';
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

$queryOldValue = "SELECT nom_formation FROM etude WHERE ID = $id";
$resultOldValue = mysqli_query($connection, $queryOldValue);
$rowOldValue = mysqli_fetch_assoc($resultOldValue);
$oldValue = $rowOldValue['nom_formation'];

if (isset($_POST['btnUpdate'])) {
    $nom = $_POST['txtnom'];

    // Mettre à jour le nom de formation dans la table etude
    $updateQuery = "UPDATE etude SET nom_formation = '$nom' WHERE ID = $id";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if ($resultQuery) {
        echo "La formation a été mise à jour avec succès.<br>";

        // Mettre à jour le meme nom de formation dans la table etude dont le type est cours qui est associé à la formation
        $updateCoursQuery = "UPDATE etude SET nom_formation = '$nom' WHERE type = 'cours' AND nom_formation = '$oldValue'";
        $resultUpdateCours = mysqli_query($connection, $updateCoursQuery);
        
        if ($resultUpdateCours) {
            echo "Les cours associés ont été mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour des cours associés.";
        }
    } else {
        echo "Erreur lors de la mise à jour de la formation.";
    }
}


$query = "SELECT * FROM etude WHERE ID = $id";
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
        Nom: <input type='text' name='txtnom' value="<?php echo $row['nom_formation'] ?>" required><br>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='list_formation.php'>Aller à la liste formation</a>
</body>
</html>

