<?php
// Démarrer la session
session_start();
include('../../dbConn.php');
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

// Vérifier si l'ID du planning est passé en paramètre
if (isset($_GET['ID'])) {
    $planningID = $_GET['ID'];

    // Récupérer l'ID du cours correspondant au planning
    $query = "SELECT id_cours FROM plannings WHERE ID = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $planningID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $coursID = $row['id_cours'];

        // Récupérer la liste des étudiants dans la formation concernée
        $queryEtudiants = "SELECT user.ID, user.nom, user.prenom FROM user
                   INNER JOIN formations ON user.formation = formations.nom
                   INNER JOIN cours ON formations.nom = cours.nom_formation
                   WHERE cours.ID = ? AND user.role = 'etudiant'";

        $stmtEtudiants = mysqli_prepare($connection, $queryEtudiants);
        mysqli_stmt_bind_param($stmtEtudiants, "i", $coursID);
        mysqli_stmt_execute($stmtEtudiants);
        $resultEtudiants = mysqli_stmt_get_result($stmtEtudiants);

    } else {
        // Gérer le cas où aucun cours correspondant au planning n'est trouvé
        echo "Aucun cours correspondant au planning n'a été trouvé.";
        exit();
    }
} else {
    // Gérer le cas où l'ID du planning n'est pas passé en paramètre
    echo "L'ID du planning n'a pas été spécifié.";
    exit();
}

// Récupérer les absences existantes pour ce planning de cours
$queryExistingAbsences = "SELECT id_etudiant FROM absences WHERE id_planning = ?";
$stmtExistingAbsences = mysqli_prepare($connection, $queryExistingAbsences);
mysqli_stmt_bind_param($stmtExistingAbsences, "i", $planningID);
mysqli_stmt_execute($stmtExistingAbsences);
$resultExistingAbsences = mysqli_stmt_get_result($stmtExistingAbsences);

$existingAbsences = [];

while ($row = mysqli_fetch_assoc($resultExistingAbsences)) {
    $existingAbsences[] = $row['id_etudiant'];
}

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les absences sélectionnées dans le formulaire
    $selectedAbsences = isset($_POST['absent']) ? $_POST['absent'] : [];

    // Mettre à jour les absences existantes en fonction des absences sélectionnées
    foreach ($existingAbsences as $etudiantID) {
        // Vérifier si l'étudiant n'est pas sélectionné comme absent dans le formulaire
        if (!in_array($etudiantID, $selectedAbsences)) {
            // L'étudiant n'est plus sélectionné comme absent, donc supprimer l'absence de la table "absences"
            $queryDeleteAbsence = "DELETE FROM absences WHERE id_etudiant = ? AND id_planning = ?";
            $stmtDeleteAbsence = mysqli_prepare($connection, $queryDeleteAbsence);
            mysqli_stmt_bind_param($stmtDeleteAbsence, "ii", $etudiantID, $planningID);
            mysqli_stmt_execute($stmtDeleteAbsence);
        }
    }

    // Ajouter les nouvelles absences qui ont été sélectionnées
    foreach ($selectedAbsences as $etudiantID) {
        // Vérifier si l'étudiant est déjà marqué comme absent pour ce planning
        if (!in_array($etudiantID, $existingAbsences)) {
            // L'étudiant n'est pas déjà marqué comme absent, donc insérer l'absence dans la table "absences"
            $queryInsertAbsence = "INSERT INTO absences (id_etudiant, id_planning) VALUES (?, ?)";
            $stmtInsertAbsence = mysqli_prepare($connection, $queryInsertAbsence);
            mysqli_stmt_bind_param($stmtInsertAbsence, "ii", $etudiantID, $planningID);
            mysqli_stmt_execute($stmtInsertAbsence);
        }
    }

    // Rediriger vers la même page pour éviter le renvoi du formulaire lors du rafraîchissement
    header("Location: " . $_SERVER['PHP_SELF'] . "?ID=" . $planningID);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../Administrateur/absences/appel_absence.css">
    <title>Formulaire d'absences</title>
</head>

<body>
    <header>
        <h1>Système de Gestion - EFREI</h1>
    </header>
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
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
    <form action="" method="post">
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Absent</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultEtudiants)): ?>
                <tr>
                    <td>
                        <?php echo $row['ID']; ?>
                    </td>
                    <td>
                        <?php echo $row['nom']; ?>
                    </td>
                    <td>
                        <?php echo $row['prenom']; ?>
                    </td>
                    <td><input type="checkbox" name="absent[]" value="<?php echo $row['ID']; ?>" <?php if (in_array($row['ID'], $existingAbsences))
                           echo "checked"; ?>>
                    </td>
                    <td><a href="total_absences.php?etudiant=<?php echo $row['ID']; ?>">Check absence</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <input type="submit" value="Enregistrer">
    </form>
    <a href="../plannings/list_planning.php">Liste planning</a>

    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>

</html>