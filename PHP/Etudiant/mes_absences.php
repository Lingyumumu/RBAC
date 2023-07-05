<?php
// Démarrer la session
session_start();

include('../dbConn.php');

$id = $_SESSION['ID'];


// Vérifier si l'ID de l'étudiant est passé en paramètre
if (isset($_GET['ID'])) {
    $etudiantID = $_GET['ID'];

    // Récupérer les informations de l'étudiant
    $queryEtudiant = "SELECT nom, prenom FROM user WHERE ID = ?";
    $stmtEtudiant = mysqli_prepare($connection, $queryEtudiant);
    mysqli_stmt_bind_param($stmtEtudiant, "i", $etudiantID);
    mysqli_stmt_execute($stmtEtudiant);
    $resultEtudiant = mysqli_stmt_get_result($stmtEtudiant);

    if ($rowEtudiant = mysqli_fetch_assoc($resultEtudiant)) {
        $etudiantNom = $rowEtudiant['nom'];
        $etudiantPrenom = $rowEtudiant['prenom'];

        // Récupérer la liste des absences de l'étudiant
        $queryAbsences = "SELECT cours.nom_cours, plannings.jour, plannings.heure_debut, plannings.heure_fin
                          FROM absences
                          INNER JOIN plannings ON absences.id_planning = plannings.ID
                          INNER JOIN cours ON plannings.id_cours = cours.ID
                          WHERE absences.id_etudiant = ?";
        $stmtAbsences = mysqli_prepare($connection, $queryAbsences);
        mysqli_stmt_bind_param($stmtAbsences, "i", $etudiantID);
        mysqli_stmt_execute($stmtAbsences);
        $resultAbsences = mysqli_stmt_get_result($stmtAbsences);

        // Compter le nombre d'absences
        $totalAbsences = mysqli_num_rows($resultAbsences);
    } else {
        // Gérer le cas où aucun étudiant correspondant à l'ID n'est trouvé
        echo "Aucun étudiant correspondant à l'ID n'a été trouvé.";
        exit();
    }
} else {
    // Gérer le cas où l'ID de l'étudiant n'est pas passé en paramètre
    echo "L'ID de l'étudiant n'a pas été spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes absences</title>
    <link rel="stylesheet" type="text/css" href="mes_absences.css">
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
            <li><a href="../Etudiant/Home_Etudiant.php">Accueil</a></li>
            <li><a href="../Etudiant/plannings/list_planning.php">Mon emploi-du-temps</a></li>
            <li><a href="../Etudiant/cours_inscrit.php">Cours</a></li>
            <li><a href="../Etudiant/notes/list_note.php">Mes notes</a></li>
            <?php echo '<li><td><a href="mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../logout.php">Deconnexion</a></li>
        </ul>
    </nav>

<h2>Mes absences</h2>
<h3>Nom de l'étudiant : <?php echo $etudiantNom . ' ' . $etudiantPrenom; ?></h3>

<?php
// Vérifier si des absences existent
if ($totalAbsences > 0) {
    echo "<p>Nombre total d'absences : " . $totalAbsences . "</p>";
    echo "<table>";
    echo "<tr><th>Nom du cours</th><th>Date</th><th>Heure de début</th><th>Heure de fin</th></tr>";
    while ($rowAbsence = mysqli_fetch_assoc($resultAbsences)) {
        echo "<tr>";
        echo "<td>" . $rowAbsence['nom_cours'] . "</td>";
        echo "<td>" . $rowAbsence['jour'] . "</td>";
        echo "<td>" . $rowAbsence['heure_debut'] . "</td>";
        echo "<td>" . $rowAbsence['heure_fin'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucune absence enregistrée pour cet étudiant.</p>";
}
?>

</body>
</html>