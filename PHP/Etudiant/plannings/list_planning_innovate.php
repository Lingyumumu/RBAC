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

// Récupérer la liste des plannings depuis la base de données
$query = "SELECT plannings.ID, plannings.jour, plannings.heure_debut, plannings.heure_fin, cours.nom_cours, user.nom AS nom_professeur, salles.nom AS nom_salle
          FROM plannings
          INNER JOIN cours ON plannings.id_cours = cours.ID
          INNER JOIN user ON plannings.id_professeur = user.ID
          INNER JOIN salles ON plannings.id_salle = salles.ID
          ORDER BY plannings.jour ASC, plannings.heure_debut ASC";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the "nextWeek" button is clicked
    if (isset($_POST['nextWeek'])) {
        $currentWeekNumber++; // Increment the current week number
    }
    // Check if the "previousWeek" button is clicked
    elseif (isset($_POST['previousWeek'])) {
        $currentWeekNumber--; // Decrement the current week number
    }
}

// Filtrer les plannings pour n'afficher que ceux de la semaine actuelle
$planningsByWeek = array();
foreach ($planningsByDay as $jour => $plannings) {
    $planningWeekNumber = date('W', strtotime($jour));
    // Si le numéro de la semaine actuelle est égal au numéro de la semaine du planning
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: black;
        }

        td {
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eaeaea;
        }

        td.course {
            background-color: #e1f7f4;
            font-weight: bold;
        }

        td.course .course-time {
            font-size: 14px;
            margin-bottom: 5px;
        }

        td.course .course-details {
            font-size: 12px;
        }

        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }

            td,
            th {
                padding: 5px;
            }
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
            <li><a href="../cours_inscrit.php">Documents</a></li>
            <li><a href="../notes/list_note.php">Mes notes</a></li>
            <?php echo '<li><a href="../mes_absences.php?ID=' . $id . '">Mes Absences</a><li>';?>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../../logout.php">Deconnexion</a></li>
        </ul>
    </nav>
    <div>
                <form method="post" action="">
                <input type="submit" name="nextWeek" value="Semaine suivante">
                <input type="submit" name="previousWeek" value="Semaine précédente">
                </form>
            </div>
    <?php setlocale(LC_TIME, 'fr_FR.UTF-8'); ?> <!-- Définir la locale en français -->

        

    <table>
        <tr>
            <th>Heure</th>
            <?php for ($i = 0; $i < 7; $i++) : ?>
            <?php
                // Calculer la date du jour courant dans la semaine
                $currentDay = date('Y-m-d', strtotime('this week +'.$i.' days'));
                ?>
                <th><?php echo strftime("%A %e %B", strtotime($currentDay)); ?></th> <!-- Affichage de la date en détail en français -->
            <?php endfor; ?>

        </tr>

        <?php for ($hour = 8; $hour <= 19; $hour++) : ?>
            <?php for ($minute = 0; $minute < 60; $minute += 15) : ?>
                <?php $currentTime = sprintf('%02d:%02d', $hour, $minute); ?>
                <tr>
                    <?php if ($minute === 0) : ?>
                        <td><?php echo $hour . ':00'; ?></td>
                    <?php else : ?>
                        <td><?php echo $hour . ':' . $minute; ?></td>
                    <?php endif; ?>

                    <?php for ($i = 0; $i < 7; $i++) : ?>
                        <?php
                        // Calculer la date du jour courant dans la semaine
                        $currentDay = date('Y-m-d', strtotime('+' . $i . ' days', strtotime('this week', strtotime('now'))));


                        ?>

                        <?php if (isset($planningsByWeek[$currentDay])) : ?>
                            <?php $hasCourse = false; ?>
                            <?php foreach ($planningsByWeek[$currentDay] as $row) : ?>
                                <?php $startHour = substr($row['heure_debut'], 0, 2); ?>
                                <?php $startMinute = substr($row['heure_debut'], 3, 2); ?>
                                <?php $endHour = substr($row['heure_fin'], 0, 2); ?>
                                <?php $endMinute = substr($row['heure_fin'], 3, 2); ?>

                                <?php $startTime = $startHour . ':' . $startMinute; ?>
                                <?php $endTime = $endHour . ':' . $endMinute; ?>

                                <?php if ($currentTime >= $startTime && $currentTime < $endTime) : ?>
                                    <?php if ($currentTime === $startTime) : ?>
                                        <td class="course" rowspan="<?php echo ceil(($endHour - $startHour) * 4 + ($endMinute - $startMinute) / 15); ?>">
                                            <div class="course-time">
                                                <?php echo ($startMinute === '00') ? $startHour . ':00' : $startTime; ?>
                                                -
                                                <?php echo ($endMinute === '00') ? $endHour . ':00' : $endTime; ?>
                                            </div>
                                            <div class="course-details">
                                                <?php echo $row['nom_cours']; ?><br>
                                                (<?php echo $row['nom_salle']; ?>)<br>
                                                <?php echo $formation; ?>
                                            </div>
                                        </td>
                                        <?php $hasCourse = true; ?>
                                    <?php else : ?>
                                        <?php $hasCourse = true; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php endforeach; ?>

                                <?php if (!$hasCourse) : ?>
                                <td></td>
                            <?php endif; ?>

                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>

                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        <?php endfor; ?>
    </table>

</body>
</html>
