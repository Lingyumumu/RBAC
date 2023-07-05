<?php
session_start();
include('../../dbConn.php');
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}

$formation = $_GET['nom_formation'];

// Vérifier si l'utilisateur est connecté avec un ID dans la session est différent de null

$id = $_SESSION['ID'];


// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT * FROM cours WHERE nom_formation = '$formation' ";
$resultCours = mysqli_query($connection, $queryCours);

// Fermer la connexion à la base de données
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des cours - Administrateur</title>
    <link rel="stylesheet" type="text/css" href="cours_assigner.css">
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

<a href='plannings/list_planning.php'>ajouter un cours</a>

<h2>Liste des cours</h2>

<?php
// Vérifier si des cours ont été trouvés
if (mysqli_num_rows($resultCours) > 0) {
    // Afficher les cours dans un tableau
    echo "<table>
            <tr>
                <th>Nom du cours</th>
                <th>Formation</th>
                <th>Actions</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultCours)) {
        $idCours = $row['ID'];
        $nomCours = $row['nom_cours'];
        $formation = $row['nom_formation'];
        //<td><a href='document/list_documents.php?ID=$idCours'>Voir</a></td>
        echo "<tr>
                <td>$nomCours</td>
                <td>$formation</td>
                <td><a href='create_documents.php?ID=$idCours'>Ajouter un Cours</a></td>

              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>

</body>
</html>
