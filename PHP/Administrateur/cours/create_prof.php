<?php
include ('../../dbConn.php');
$id = $_GET['ID'];
if (isset($_GET['ID']) == null ){
    header("location: list_cours.php");
    exit;
}

if (isset($_POST['btnUpdate'])){
    $prof = $_POST['txtnomf'];

    $updateQuery = "UPDATE cours SET nom_prof = '$prof' WHERE ID = $id";
    $resultQuery = mysqli_query($connection, $updateQuery);

    if($resultQuery){
        echo "L'utilisateur a été mis à jour avec succès.<br>";
        // Valider la transaction
        mysqli_commit($connection);
    }
    else{
        echo "Erreur lors de la mise à jour de l'utilisateur : " . mysqli_error($connection) . "<br>";
    }
}

$query1 = "SELECT * FROM cours WHERE ID = $id";
$result1 = mysqli_query($connection, $query1);
$row1 = mysqli_fetch_assoc($result1);
$form = $row1['nom_formation'];

$query = "SELECT * FROM user WHERE role = 'professeur' AND formation = '$form'";
$result = mysqli_query($connection, $query);

echo "<a href='list_cours.php'>Aller à la liste des cours</a>";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../Administrateur/cours/create_prof.css">
    <meta charset="UTF-8">
    <title>Page de modification</title>
</head>
<body>
    <h1>Page de modification</h1>
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
    <form action="" method="post">
        <?php 
        echo "Nom du cours: " . $row1['nom_cours'] . "<br>";
        echo "Nom de la formation: " . $row1['nom_formation'] . "<br>";
        if ($row1['nom_prof'] == null){
            echo "Nom du professeur Actuel: Aucun professeur n'est assigné à ce cours.<br>";
        }
        else
        echo "Nom du professeur Actuel: " . $row1['nom_prof'] . "<br>";
        ?>
        Nom du Professeur:
        <select name="txtnomf">
            <?php
            while($row = mysqli_fetch_assoc($result)){
                echo '<option value="' . $row['nom'] . '">' . $row['nom'] . '</option>';
            }
            ?>
        </select>
        <br><br>
        <input type="submit" name="btnUpdate" value="Mettre à jour">
    </form>
    <br><br>
    <a href="list_formation.php">Aller à la liste des formations</a>
</body>
</html>
