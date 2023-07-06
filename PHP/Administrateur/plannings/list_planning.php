<?php
include('../../dbConn.php');

session_start();  
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

$idCours = $_GET['ID'];

// Récupérer la liste des cours depuis la base de données
$queryCours = "SELECT * FROM cours ";
$resultCours = mysqli_query($connection, $queryCours);
$rowCours = mysqli_fetch_assoc($resultCours);

$queryProfessors = "SELECT ID, nom FROM user WHERE role = 'professeur'";
$resultProfessors = mysqli_query($connection, $queryProfessors);

// Récupérer la liste des salles depuis la base de données
$querySalles = "SELECT ID, nom FROM salles";
$resultSalles = mysqli_query($connection, $querySalles);

// Filtrer les plannings en fonction des critères sélectionnés



// Récupérer la liste des plannings filtrés depuis la base de données
//if ($idCours != '') {
    $query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_formation, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
    FROM plannings 
    INNER JOIN cours ON plannings.id_cours = cours.ID
    INNER JOIN user ON plannings.id_professeur = user.ID
    INNER JOIN salles ON plannings.id_salle = salles.ID
    WHERE plannings.id_cours = $idCours
    ORDER BY plannings.jour ASC, plannings.heure_debut ASC";

//} else {
    /*$query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_formation, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings 
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID";
//}
/*
if ($idCours != '') {
    $query .= " AND plannings.id_cours = $idCours";
}*/

$result = mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../Administrateur/plannings/list_planning.css">
    <title>Liste des plannings</title>
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                altFormat: 'mm',
                altField: '#monthpicker',
            });
        });
    </script>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
<header>
        <h1>EFREI - Administrateur</h1>
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
    </header>
<style>
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding: 5px;
    }
</style>
<h2>Liste des plannings</h2>


<table>
    <thead>
        <tr>
            <th>Formation</th>
            <th>Cours</th>
            <th>Jour</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th>Professeur</th>
            <th>Salle</th>
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['nom_formation']; ?></td>     
            <td><?php echo $row['nom_cours']; ?></td>  
            <td><?php echo $row['jour']; ?></td>
            <td><?php echo $row['heure_debut']; ?></td>
            <td><?php echo $row['heure_fin']; ?></td>
            <td><?php echo $row['nom_professeur']; ?></td>
            <td><?php echo $row['nom_salle']; ?></td>
            <td><a href="../absences/appel_absence.php?ID=<?php echo $row['ID']; ?>">Appel absence</a></td>
            <td><a href="edit_planning.php?ID=<?php echo $row['ID']; ?>">Modifier</a></td>
            <td><a href="delete_planning.php?ID=<?php echo $row['ID']; ?>">Supprimer</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>


