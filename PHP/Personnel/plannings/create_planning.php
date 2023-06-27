<?php
include('../../dbConn.php');

// Vérifier si la clé 'cours' existe dans $_GET
$id = $_GET['ID'];
if ($id == null) {
    header("location: list_planning.php");
    exit();
}

$queryCours = "SELECT * FROM cours WHERE ID = $id";
$resultCours = mysqli_query($connection, $queryCours);
$rowCours = mysqli_fetch_assoc($resultCours);

$queryProfessors = "SELECT * FROM user WHERE nom = '$rowCours[nom_prof]'";
$resultProfessors = mysqli_query($connection, $queryProfessors);
$rowProfessors = mysqli_fetch_assoc($resultProfessors);





if (isset($_POST['btnRegister'])) {
    // Récupérer les données du formulaire
    $jour = $_POST['txtjour'];
    $heure_debut = $_POST['txtHeured'] . ":" . $_POST['txtMinuted'];
    $heure_fin = $_POST['txtHeuref'] . ":" . $_POST['txtMinutef'];
    $id_cours = $id;
    $id_professeur = $rowProfessors['ID'];
    $id_salle = $_POST['txtSalle'];

    echo $jour. "<br>";
    echo $heure_debut. "<br>";
    echo $heure_fin. "<br>" ;
    echo $id_cours. "<br>";
    echo $id_professeur. "<br>";
    echo $id_salle. "<br>";

    // Créer la requête de creation d'un planning
    $query = "INSERT INTO plannings (jour, heure_debut, heure_fin, id_cours, id_professeur,id_salle ) VALUES ('$jour', '$heure_debut', '$heure_fin', '$id_cours', '$id_professeur', '$id_salle')";
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
        <li><a href="../Home_Admin.php">Accueil</a></li>
        <li><a href="../notes/index_notes.php">Notes</a></li>
        <li><a href="../cours/index_cours.php">Cours</a></li>
        <li><a href="../formations/index_formations.php">Formations</a></li>
        <li><a href="../salles/index_salles.php">Salles</a></li>
        <li><a href="index_plannings.php">Plannings</a></li>
        <li><a href="../absences/index_absences.php">Absences</a></li>
        <li><a href="etudiants.html">Étudiants</a></li>
        <li><a href="enseignants.html">Enseignants</a></li>
        <li><a href="utilisateurs.html">Utilisateurs</a></li>
        <li><a href="configurations.html">Configurations</a></li>
        <li><a href="securite.html">Sécurité</a></li>
    </ul>
</nav>

<h2>Création Planning</h2>
<a href="list_planning.php"><button>Liste planning</button></a>
<form action="" method="post">
    Jour: <input type="text" id="datepicker" name="txtjour" required><br>

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

        echo "Nom du cours: " . $rowCours['nom_cours'] . "<br>";
        echo "Nom du professeur: " . $rowCours['nom_prof'] . "<br>";
    ?>


    Salle <select name="txtSalle">
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