<?php
session_start();
include('../dbConn.php');
if ($_SESSION['role'] != 'professeur') {
    header("location: ../login.php");
}


// Vérifier si l'utilisateur est connecté avec un ID dans la session est différent de null

$id = $_SESSION['ID'];
$nom = $_SESSION['nom'];

// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT * FROM cours WHERE nom_prof = '$nom'";
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
            <li><a href="../Professeur/Home_Professeur.php">Accueil</a></li>
            <li><a href="../Professeur/notes/list_etudiant_note.php">Notes</a></li>
            <li><a href="cours_assigner.php">Document</a></li>
            <li><a href="../Professeur/plannings/list_planning.php">Planning</a></li>
            <li><a href="../Message.php">Message</a></li>
            <li><a href="../logout.php">Deconnexion</a></li>
        </ul>
    </nav>


<h2>Liste des Documents</h2>

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
                <td><a href='document/create_documents.php?ID=$idCours'>Ajouter un Cours</a></td>

              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>

</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>
