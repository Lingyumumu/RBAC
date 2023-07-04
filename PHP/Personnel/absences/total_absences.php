<?php
include('../../dbConn.php');

// Vérifier si l'ID de l'étudiant est passé en paramètre
if (isset($_GET['etudiant'])) {
    $etudiantID = $_GET['etudiant'];

    // Récupérer les détails de l'étudiant
    $queryEtudiant = "SELECT user.nom, user.prenom, formations.nom AS formation, user.email
                      FROM user
                      INNER JOIN formations ON user.formation = formations.nom
                      WHERE user.ID = ?";
    $stmtEtudiant = mysqli_prepare($connection, $queryEtudiant);
    mysqli_stmt_bind_param($stmtEtudiant, "i", $etudiantID);
    mysqli_stmt_execute($stmtEtudiant);
    $resultEtudiant = mysqli_stmt_get_result($stmtEtudiant);
    $rowEtudiant = mysqli_fetch_assoc($resultEtudiant);

    // Récupérer les absences de l'étudiant
    $queryAbsences = "SELECT plannings.jour, cours.nom_cours, plannings.heure_debut, plannings.heure_fin
                      FROM plannings
                      INNER JOIN cours ON plannings.id_cours = cours.ID
                      WHERE plannings.ID IN (SELECT id_planning FROM absences WHERE id_etudiant = ?)";
    $stmtAbsences = mysqli_prepare($connection, $queryAbsences);
    mysqli_stmt_bind_param($stmtAbsences, "i", $etudiantID);
    mysqli_stmt_execute($stmtAbsences);
    $resultAbsences = mysqli_stmt_get_result($stmtAbsences);
    $totalAbsences = mysqli_num_rows($resultAbsences);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../Administrateur/absences/total_absences.css">
    <title>Total des absences</title>
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
<h1>EFREI - Personnel Administratif</h1>
        <nav>
            <ul>
                <li><a href="../Personnel/Home_Personnel.php">Accueil</a></li>
                <li><a href="../Personnel/cours/list_cours.php">Cours</a></li>
                <li><a href="../Personnel/plannings/index_plannings.php">¨Planning</a></li>
                <li><a href="../Personnel/notes/list_notes.php">Notes</a></li>
                <li><a href="../Personnel/user/list_user.php">Utilisateurs</a></li>
            </ul>
        </nav>
<h2>Total des absences</h2>

<?php
// Vérifier si les détails de l'étudiant sont définis
if (isset($rowEtudiant)) {
    // Afficher les détails de l'étudiant
    echo "<p>Nom : " . $rowEtudiant['nom'] . "</p>";
    echo "<p>Prénom : " . $rowEtudiant['prenom'] . "</p>";
    echo "<p>Formation : " . $rowEtudiant['formation'] . "</p>";
    echo "<p>E-mail : " . $rowEtudiant['email'] . "</p>";

    // Vérifier si des absences existent
    if ($totalAbsences > 0) {
        echo "<p>Nombre total d'absences : " . $totalAbsences . "</p>";
        echo "<p>Détails de chaque absence :</p>";
        echo "<table>";
        echo "<tr><th>Nom du cours</th><th>Date</th><th>Heure de début</th><th>Heure de fin</th></tr>";
        while ($row = mysqli_fetch_assoc($resultAbsences)) {
            echo "<tr>";
            echo "<td>" . $row['nom_cours'] . "</td>";
            echo "<td>" . $row['jour'] . "</td>";
            echo "<td>" . $row['heure_debut'] . "</td>";
            echo "<td>" . $row['heure_fin'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucune absence enregistrée pour cet étudiant.</p>";
    }
} else {
    echo "<p>Aucune information d'étudiant trouvée.</p>";
}
?>
</body>
</html>
