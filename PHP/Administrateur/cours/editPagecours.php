<?php
include ('../../dbConn.php');
$id = $_GET['ID'];
if (isset($_GET['ID']) == null ){
    header("location: list_cours.php");
}
// Récupérer l'ancien nom de formation

if (isset($_POST['btnUpdate'])){
    $nomf = $_POST['txtnomf'];
    $nomc = $_POST['txtnomc'];


    $updateQuery = "UPDATE cours SET nom_formation = '$nomf', nom_cours = '$nomc' WHERE id = $id";
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

$query = "SELECT * FROM cours WHERE ID = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

echo "<a href='list_cours.php'>Aller à la liste cours</a>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="editPagecours.css">
</head>
<body>
    <h1>Page de modification</h1>
    <form action='' method='post'>
        Nom du Cours: <input type='text' name='txtnomc' value="<?php echo $row['nom_cours'] ?>" required><br>
        Nom de Formation: <select name="txtnomf">
            <option value="<?php echo $row['nom_formation'] ?>"><?php echo $row['nom_formation'] ?></option>
            <?php
            $query = "SELECT * FROM formations";
            $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result)){

                echo '<option value="' . $row['nom'] . '">' . $row['nom'] . '</option>';
            }
            ?>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='list_formation.php'>Aller à la liste formation</a>
</body>
</html>
