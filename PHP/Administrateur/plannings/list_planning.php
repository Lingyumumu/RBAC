<?php
include('../../dbConn.php');

session_start();  
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

$queryformation = "SELECT * FROM user";
$resultformation = mysqli_query($connection, $queryformation);
$rowformation = mysqli_fetch_assoc($resultformation);
$formation = $rowformation['formation'];

// Récupérer la liste des cours depuis la base de données
$queryCours = "SELECT ID, nom_cours FROM cours WHERE nom_formation = '$formation'";
$resultCours = mysqli_query($connection, $queryCours);

$queryProfessors = "SELECT ID, nom FROM user WHERE role = 'professeur'";
$resultProfessors = mysqli_query($connection, $queryProfessors);

// Récupérer la liste des salles depuis la base de données
$querySalles = "SELECT ID, nom FROM salles";
$resultSalles = mysqli_query($connection, $querySalles);

// Récupérer la liste des plannings filtrés depuis la base de données
if (isset($_POST['btnRegister']) && ($_POST['txtjour'] != '')) {
    $jour = $_POST['txtjour'];
    $query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours, cours.nom_formation, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          WHERE plannings.jour = '$jour'
          ORDER BY plannings.jour ASC, plannings.heure_debut ASC";


}else{
$query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours,cours.nom_formation, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          ORDER BY plannings.jour ASC, plannings.heure_debut ASC"; // Ajoutez ORDER BY pour trier par jour et heure de début

}

$result = mysqli_query($connection, $query);

// Fermer la connexion à la base de données
mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des plannings</title>
    <link rel="stylesheet" href="../../Administrateur/plannings/list_planning.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    
    <script>
         $(document).ready(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
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

        footer{
        text-align: center;
        }
        
    </style>
</head>
<body>
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
<form action="" method="post">
    Jour: <input type="text" id="datepicker" name="txtjour">
    <input type="submit" name="btnRegister" value="Filtrer">
    </form>

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


