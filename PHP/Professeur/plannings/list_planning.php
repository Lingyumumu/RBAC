<?php
include('../../dbConn.php');
session_start();

// Si l'utilisateur n'est pas connecté ou n'est pas un étudiant, le rediriger vers la page de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professeur') {
    header('Location: ../../login.php');
    exit;
}

$id = $_SESSION['ID'];
$queryformation = "SELECT * FROM user WHERE ID = '$id'";
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
    $query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          WHERE plannings.jour = '$jour' AND user.ID = '$id'
          ORDER BY plannings.jour ASC, plannings.heure_debut ASC";


}else{
$query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          WHERE user.ID = '$id'
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
    <link rel="stylesheet" href="list_planning.css">
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

<header>
<h1>Système de Gestion de l'EFREI</h1>
</header>
<nav>
    <ul>
        <li><a href="../Home_Professeur.php">Accueil</a></li>
        <li><a href="../notes/list_etudiant_note.php">Notes</a></li>
        <li><a href="../cours_assigner.php">Document</a></li>
        <li><a href="../plannings/list_planning.php">Plannings</a></li>
        <li><a href="../../Message.php">Message</a></li>
        <li><a href="../../logout.php">Deconnexion</a></li>
    </ul>
</nav>
    <h1>Liste des plannings</h1>
    <form action="" method="post">
    Jour: <input type="text" id="datepicker" name="txtjour">
    <input type="submit" name="btnRegister" value="Filtrer">
    </form>
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <table>
            <tr>
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Cours</th>
                <th>Salle</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['jour']; ?></td>
                    <td><?php echo $row['heure_debut']; ?></td>
                    <td><?php echo $row['heure_fin']; ?></td>
                    <td><?php echo $row['nom_cours']; ?></td>
                    <td><?php echo $row['nom_salle']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>Il n'y a pas.</p>
    <?php endif; ?>


</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>
