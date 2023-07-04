<?php
include('../../dbConn.php');
session_start();
//Si l'utilisateur n'est pas connecté ou n'est pas un étudiant, le rediriger vers la page de connexion
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

// Filtrer les plannings en fonction des critères sélectionnés
$whereClause = '';
$whereConditions = array();

/*
if (isset($_GET['btnFilter'])) {
    $coursFilter = $_GET['ddlCours'];
    $jourFilter = isset($_GET['txtjour']) ? $_GET['txtjour'] : '';
    $salleFilter = $_GET['ddlSalles'];
    $professeurFilter = $_GET['ddlProfesseurs'];

    if ($coursFilter != '0') {
        $whereConditions[] = "plannings.id_cours = '$coursFilter'";
    }
    if (!empty($jourFilter)) {
        $whereConditions[] = "plannings.jour = '$jourFilter'";
    }
    if ($salleFilter != '0') {
        $whereConditions[] = "plannings.id_salle = '$salleFilter'";
    }
    if ($professeurFilter != '0') {
        $whereConditions[] = "user.ID = '$professeurFilter'";
    }

    if (!empty($whereConditions)) {
        $whereClause = 'WHERE ' . implode(' AND ', $whereConditions);
    }
}*/

// Récupérer la liste des plannings filtrés depuis la base de données
$query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          $whereClause";
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
    <h1>Système de gestion de l'EFREI</h1>
</header>
<nav>
    <ul>
        <li><a href="../Home_Etudiant.php">Accueil</a></li>
        <li><a href="../plannings/list_planning.php">Mon emploi-du-temps</a></li>
        <li><a href="../cours_inscrit.php">Cours</a></li>
        <li><a href="../notes/list_note.php">Mes notes</a></li>
        <?php echo '<li><td><a href="../mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
        <li><a href="../../logout.php">Deconnexion</a></li>
        
    </ul>
</nav>
<?php /*
<h2>Liste des plannings</h2>
<form action="" method="get">
    <label for="ddlCours">Cours:</label>
    <select name="ddlCours">
        <option value="0">Tous les cours</option>
        <?php while ($row = mysqli_fetch_assoc($resultCours)) : ?>
            <option value="<?php echo $row['ID']; ?>" <?php if (isset($_GET['ddlCours']) && $_GET['ddlCours'] == $row['ID']) echo 'selected'; ?>><?php echo $row['nom_cours']; ?></option>
        <?php endwhile; ?>
    </select>

    <label for="ddlProfesseurs">Professeur:</label>
    <select name="ddlProfesseurs">
        <option value="0">Tous les professeurs</option>
        <?php while ($row = mysqli_fetch_assoc($resultProfessors)) : ?>
            <option value="<?php echo $row['ID']; ?>" <?php if (isset($_GET['ddlProfesseurs']) && $_GET['ddlProfesseurs'] == $row['ID']) echo 'selected'; ?>><?php echo $row['nom']; ?></option>
        <?php endwhile; ?>
    </select>


    <label for="ddlSalles">Salle:</label>
    <select name="ddlSalles">
        <option value="0">Toutes les salles</option>
        <?php while ($row = mysqli_fetch_assoc($resultSalles)) : ?>
            <option value="<?php echo $row['ID']; ?>" <?php if (isset($_GET['ddlSalles']) && $_GET['ddlSalles'] == $row['ID']) echo 'selected'; ?>><?php echo $row['nom']; ?></option>
        <?php endwhile; ?>
    </select>

    <input type="submit" name="btnFilter" value="Filtrer">

    <input type="hidden" id="monthpicker" name="txtmois">

</form>
*/ ?>

<?php foreach ($planningsByDay as $jour => $plannings) : ?>
    <h3><?php echo $jour; ?></h3>
    <table>
        <tr>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th>Cours</th>
            <th>Salle</th>
        </tr>
        <?php foreach ($plannings as $row) : ?>
            <tr>
                <td><?php echo $row['heure_debut']; ?></td>
                <td><?php echo $row['heure_fin']; ?></td>
                <td><?php echo $row['nom_cours']; ?></td>
                <td><?php echo $row['nom_salle']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endforeach; ?>

</body>
</html>
