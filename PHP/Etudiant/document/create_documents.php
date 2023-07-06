<?php
include('../../dbConn.php');
session_start();

$id = $_SESSION['ID'];
$role = $_SESSION['role'];
$idCours = $_GET['ID'];
if ($idCours == null) {
    header("location: ../../login.php");
}

$query = "SELECT * FROM documents WHERE ID_cours = '$idCours' AND role_expediteur = 'professeur'";
$results = mysqli_query($connection, $query);

$queryprof = "SELECT * FROM cours WHERE ID = '$idCours'";
$resultsprof = mysqli_query($connection, $queryprof);
$rowprof = mysqli_fetch_assoc($resultsprof);
$nom_prof = $rowprof['nom_prof'];

?>

<header>
<h1>Système de Gestion de l'EFREI</h1>
</header>

<nav>
    <ul>
            <li><a href="../Home_Etudiant.php">Accueil</a></li>
            <li><a href="../plannings/index_plannings.php">Mon emploi-du-temps</a></li>
            <li><a href="../notes/list_note.php">Mes notes</a></li>
            <li><a href="../cours_inscrit.php">Documents</a></li>
            <?php echo '<li><a href="../mes_absences.php?ID=' . $id . '">Mes Absences</a><li>';?>
            <li><a href="../../Message.php">Message</a></li>
            <li><a href="../../logout.php">Deconnexion</a></li>
    </ul>
</nav>

<h2>Liste des documents</h2>
<html>

<body>

    <head>
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="create_documents.css">
    </head>



    <a href="../cours_inscrit.php">Retour</a>
    <table border="1" cellspacing='10'>
        <tr>
            <th>Nom document</th>
            <th>Expéditeur</th>
            <th>Date</th>

        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)) {

            echo '<tr>';
            echo '<td><a href="download_documents.php?ID=' . $row['ID'] . '">' . $row['nom_fichier'] . '</a></td>';
            echo '<td>' . $nom_prof . '</td>';
            echo '<td>' . $row['date'] . '</td>';

            echo '</tr>';
        }
        ?>
    </table>

</body>

</html>