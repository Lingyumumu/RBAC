<?php
include('../../dbConn.php');
session_start();

// Si l'utilisateur n'est pas connecté ou n'est pas un étudiant, le rediriger vers la page de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../../login.php');
    exit;
}

$id = $_SESSION['ID'];
$queryformation = "SELECT formation FROM user WHERE ID = '$id'";
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
// Récupérer la liste des plannings filtrés depuis la base de données
$query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          ORDER BY plannings.jour ASC, plannings.heure_debut ASC"; // Ajoutez ORDER BY pour trier par jour et heure de début
$result = mysqli_query($connection, $query);


// Grouper les plannings par jour
$planningsByDay = array();
while ($row = mysqli_fetch_assoc($result)) {
    $jour = $row['jour'];
    if (!isset($planningsByDay[$jour])) {
        $planningsByDay[$jour] = array();
    }
    $planningsByDay[$jour][] = $row;
}

// Obtenir le numéro de la semaine actuelle
$currentWeekNumber = date('W');

// Filtrer les plannings pour n'afficher que ceux de la semaine actuelle
$planningsByWeek = array();
foreach ($planningsByDay as $jour => $plannings) {
    $planningWeekNumber = date('W', strtotime($jour));
    if ($planningWeekNumber == $currentWeekNumber) {
        $planningsByWeek[$jour] = $plannings;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des plannings</title>
    <link rel="stylesheet" href="list_planning.css">
    
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
<h1>Système de Gestion de l'EFREI</h1>
</header>
<nav>
    <ul>
        <li><a href="../Home_Etudiant.php">Accueil</a></li>
        <li><a href="../plannings/list_planning.php">Mon emploi-du-temps</a></li>
        <li><a href="../cours_inscrit.php">Cours</a></li>
        <li><a href="../notes/list_note.php">Mes notes</a></li>
        <?php echo '<li><td><a href="../mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
        <li><a href="../../Message.php">Message</a></li>
        <li><a href="../../logout.php">Deconnexion</a></li>
        
    </ul>
</nav>



<?php setlocale(LC_TIME, 'fr_FR.UTF-8'); ?> <!-- Définir la locale en français -->
<?php for ($i = 0; $i < 7; $i++) : ?>
    <?php
    // Calculer la date du jour courant dans la semaine
    $currentDay = date('Y-m-d', strtotime('+' . $i . ' days', strtotime('this week', strtotime('now'))));
    ?>

    <h3><?php echo strftime("%A %e %B %Y", strtotime($currentDay)); ?></h3> <!-- Affichage de la date en détail en français -->

    <?php if (isset($planningsByWeek[$currentDay])) : ?>
        <table>
            <tr>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Cours</th>
                <th>Salle</th>
            </tr>
            <?php foreach ($planningsByWeek[$currentDay] as $row) : ?>
                <tr>
                    <td><?php echo $row['heure_debut']; ?></td>
                    <td><?php echo $row['heure_fin']; ?></td>
                    <td><?php echo $row['nom_cours']; ?></td>
                    <td><?php echo $row['nom_salle']; ?></td>
                </tr>
                
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>Aucun planning pour ce jour.</p>
    <?php endif; ?>

<?php endfor; ?>

</body>
</html>
