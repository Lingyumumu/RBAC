<?php
include '../dbConn.php';
$id = $_GET['ID'];
// Récupérer l'ancien nom de formation

if (isset($_POST['btnUpdate'])){
    $nomf = $_POST['txtnomf'];
    $nomc = $_POST['txtnomc'];


    $updateQuery = "UPDATE etude SET nom_formation = '$nomf', nom_cours = '$nomc' WHERE id = $id";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if($resultQuery){
        echo "the user has been updated<br>";
        // Valider la transaction
        mysqli_commit($connection);

    }
    else{
        echo "the user has not been updated<br>";
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
        Nom du Cours: <input type='text' name='txtnomc' value="<?php echo $row['nom_cours'] ?>" required><br>
        Nom de Formation: <select name="txtnomf">
            <?php
            $query = "SELECT * FROM etude";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($result)){
                echo '<option value="' . $row['nom_formation'] . '">' . $row['nom_formation'] . '</option>';
            }
            ?>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='Administrateur/list_formation.php'>Aller à la liste formation</a>
</body>
</html>
