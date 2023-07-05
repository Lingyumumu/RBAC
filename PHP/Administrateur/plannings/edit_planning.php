<?php
session_start();
include('../../dbConn.php');

if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}
// Vérifier si la clé 'cours' existe dans $_GET
$id = $_GET['ID'];
if ($id == null) {
    header("location: list_planning.php");
    exit();
}


// Récupérer l'ancien nom de formation

$queryActuel = "SELECT * FROM plannings WHERE ID = '$id'";
$resultActuel = mysqli_query($connection, $queryActuel);
$rowActuel = mysqli_fetch_assoc($resultActuel);





if (isset($_POST['btnRegister'])) {
    // Récupérer les données du formulaire
    $jour = $_POST['txtjour'];
    $heure_debut = $_POST['txtHeured'] . ":" . $_POST['txtMinuted'];
    $heure_fin = $_POST['txtHeuref'] . ":" . $_POST['txtMinutef'];
    $id_cours = $rowActuel['id_cours'];
    $id_professeur = $rowActuel['id_professeur'];
    $id_salle = $_POST['txtSalle'];

    echo $jour. "<br>";
    echo $heure_debut. "<br>";
    echo $heure_fin. "<br>" ;
    echo $id_cours. "<br>";
    echo $id_professeur. "<br>";
    echo $id_salle. "<br>";

    // Créer la requête de creation d'un planning
    $query = "UPDATE plannings SET jour = '$jour', heure_debut = '$heure_debut',
    heure_fin = '$heure_fin', id_cours = '$id_cours', id_professeur = '$id_professeur' , id_salle = '$id_salle' WHERE ID = $id";
    $resultQuery = mysqli_query($connection, $query);

    if($resultQuery){
        echo "L'utilisateur a été mis à jour avec succès.<br>";
        // Valider la transaction
        mysqli_commit($connection);
    }
    else{
        echo "Erreur lors de la mise à jour de l'utilisateur : " . mysqli_error($connection) . "<br>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Création Planning</title>
    <link rel="stylesheet" href="../../Administrateur/plannings/edit_planning.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
</head>
<body>
<nav>
    <ul>
                <li><a href="../../Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="../../Personnel/cours/list_formation.php">Cours</a></li>
                <li><a href="../../Personnel/plannings/list_formation.php">Planning</a></li>
                <li><a href="../../Personnel/notes/list_formation.php">Notes</a></li>
                <li><a href="../../Personnel/user/list_register.php">Utilisateurs</a></li>
                <li><a href="../../logout.php">Deconnexion</a></li>
    </ul>
</nav>

<h2>Création Planning</h2>
<a href="list_formation.php"><button>Liste planning</button></a>
<?php  
    if (isset($_POST['btnRegister'])) {
        echo "<br> Jour plannifier actuel : " . $jour;
    }
    else
    echo "<br> Jour plannifier actuel : " . $rowActuel['jour'];
?>
<form action="" method="post">
    Jour: <input type="text" id="datepicker" name="txtjour" required><br>
    <?php
    if (isset($_POST['btnRegister'])) {
        echo "Heure de début plannifier actuel: " . $heure_debut . "<br>";
        echo "Heure de fin plannifier actuel: " . $heure_fin . "<br>";
    }
    else{
    echo "Heure de début plannifier actuel :" .  $rowActuel['heure_debut'] . "<br>" ;
    echo "Heure de fin plannifier actuel :" .  $rowActuel['heure_fin'] . "<br>" ;
    };
    ?>

    Heure de début: <select name="txtHeured">
        <?php
        for ($i = 8; $i <= 20; $i++) {
            $heure = sprintf("%02d", $i);
            echo "<option value=\"$heure\">$heure</option>";
        }
        ?>
    </select>

    h:<select name="txtMinuted">
        <?php
        for ($i = 0; $i <= 59; $i= $i + 5) {
            $minute = sprintf("%02d", $i);
            echo "<option value=\"$minute\">$minute</option>";
        }
        ?>
    </select><br>

    Heure de fin:
    <select name="txtHeuref">
        <?php
        for ($i = 8; $i <= 20; $i++) {
            $heure = sprintf("%02d", $i);
            echo "<option value=\"$heure\">$heure</option>";
        }
        ?>
    </select>

    h:
    <select name="txtMinutef">
        <?php
        for ($i = 0; $i <= 59; $i= $i + 5) {
            $minute = sprintf("%02d", $i);
            echo "<option value=\"$minute\">$minute</option>";
        }
        ?>
    </select><br>
 
    <?php


    $idcours =$rowActuel['id_cours'];
    $querycours = "SELECT * FROM cours WHERE ID = $idcours";
    $resultcours = mysqli_query($connection, $querycours);
    $rowcours = mysqli_fetch_assoc($resultcours);

        echo "Nom du cours: " . $rowcours['nom_cours'] . "<br>";
        echo "Nom du professeur: " . $rowcours['nom_prof'] . "<br>";
     ?>


    Salle <select name="txtSalle">

        <?php
        $idSalle = $rowActuel['id_salle'];
        $querySalle = "SELECT * FROM salles WHERE ID = $idSalle";
        $resultSalleActuel = mysqli_query($connection, $querySalle);
        $rowSalleActuel = mysqli_fetch_assoc($resultSalleActuel);
        ?>
        <option value="<?php echo $rowActuel['id_salle']; ?>"><?php echo $rowSalleActuel['nom'] . '(precedent)'; ?></option>
        <?php
        $querySalles = "SELECT * FROM salles";
        $resultSalles = mysqli_query($connection, $querySalles);

        while($row = mysqli_fetch_assoc($resultSalles)): ?>
            <option value="<?php echo $row['ID']; ?>"><?php echo $row['nom']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <input type="submit" name="btnRegister" value="Créer Planning">
</form>
</body>
</html>