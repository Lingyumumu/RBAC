<?php
session_start();
include('../dbConn.php');

// Vérifier si l'utilisateur est connecté avec role professeur, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'etudiant') {
    header('Location: ../login.php');
    exit;
}

$id = $_SESSION['ID'];


$queryUser = "SELECT * FROM user WHERE ID = $id";
$resultUser = mysqli_query($connection, $queryUser);
$rowUser = mysqli_fetch_array($resultUser);
$formation = $rowUser['formation'];

// Récupérer les cours depuis la base de données avec le nom de l'enseignant et la formation
$queryCours = "SELECT * FROM cours WHERE nom_formation = '$formation' ";
$resultCours = mysqli_query($connection, $queryCours);

$queryNote = "SELECT * FROM notes WHERE id_etudiant = $id";
$resultNote = mysqli_query($connection, $queryNote);



mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des cours - Administrateur</title>
    <link rel="stylesheet" href="cours_inscrit.css">
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
            <li><a href="../Etudiant/Home_Etudiant.php">Accueil</a></li>
            <li><a href="../Etudiant/plannings/list_planning.php">Mon emploi-du-temps</a></li>
            <li><a href="../Etudiant/cours_inscrit.php">Cours</a></li>
            <li><a href="../Etudiant/notes/list_note.php">Mes notes</a></li>
            <?php echo '<li><td><a href="mes_absences.php?ID=' . $id . '">Mes Absences</a></td><li>';?>
            <li><a href="../logout.php">Deconnexion</a></li>

        </ul>
    </nav>

<h2>Liste des cours</h2>

<?php
// Vérifier si des cours ont été trouvés
if (mysqli_num_rows($resultCours)) {
    // Afficher les cours dans un tableau
    
    echo "<table>
            <tr>
                <th>Nom du cours</th>
                <th>Note</th>
            </tr>";
            while ($row = mysqli_fetch_assoc($resultCours)) {
                $idCours = $row['ID'];
                $nomCours = $row['nom_cours'];
                if ($rowNote = mysqli_fetch_assoc($resultNote)) {
                    $note = $rowNote['note'];
                } else {
                    $note = 'N/A'; // Remplacez par la valeur souhaitée si aucune note n'est présente
                }
                echo "<tr>
                        <td>$nomCours</td>
                        <td><a href='document/create_documents.php?ID=$idCours'>Document Cours</a></td>
                      </tr>";
            }
            
            
            

    echo "</table>";
} else {
    echo "Aucun cours trouvé.";
}
?>
</body>
</html>
