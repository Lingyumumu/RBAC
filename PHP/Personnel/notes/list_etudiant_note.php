<?php
//step1: create a database connection
include ('../../dbConn.php');
session_start();

if ($_SESSION['role'] != 'personnel') {
    header("location: ../../login.php");
}

$formation = $_GET['nom_formation'];

//step2: create a database query
$query = "SELECT * FROM user WHERE formation = '$formation'";

// Ajouter les conditions de filtrage si les valeurs sont définies
if (isset($_GET['btnSend'])) {
    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];
    $formation = $_GET['nom_formation'];

    $conditions = array();
    if (!empty($formation)) {
        $conditions[] = "formation = '$formation'";
    }

    if (!empty($nom)) {
        $conditions[] = "nom LIKE '%$nom%'";
    }

    if (!empty($prenom)) {
        $conditions[] = "prenom LIKE '%$prenom%'";
    }

    // Combinez les conditions avec l'opérateur AND
    if (!empty($conditions)) {
        $query .= " AND " . implode(" AND ", $conditions);
    }
}

$results = mysqli_query($connection, $query);
?>

<!Doctype html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="list_etudiant_note.css">
</head>
<body>
<header>
    <h1>Système de Gestion - EFREI</h1> 
</header>

<nav>
    <ul>
        <li><a href="../../Personnel/Home_Personnel.php">Accueil</a></li>
        <li><a href="../../Personnel/cours/list_formation.php">Cours</a></li>
        <li><a href="../../Personnel/plannings/list_formation.php">Planning</a></li>
        <li><a href="../../Personnel/notes/list_formation.php">Notes</a></li>
        <li><a href="../../Personnel/user/list_register.php">Utilisateurs</a></li>
        <li><a href="../../Message.php">Message</a></li>
        <li><a href="../../logout.php">Deconnexion</a></li>
    </ul>
</nav>

<form action="#" method="get">
    <input type="hidden" name="nom_formation" value="<?php echo $formation; ?>">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" placeholder="Nom">
    
    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" placeholder="Prénom">
    

    
    <input type="submit" value="Filtrer" name="btnSend">
    <input type="reset" value="Effacer">
</form>

<h2>Admin Students Details</h2>

<table border="1" cellspacing='10'>
    <tr>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Details</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($results)) {
        echo '<tr>';
        echo '<td>'. $row['nom'] . '</td>';
        echo '<td>'. $row['prenom'] . '</td>';
        echo '<td><a href="list_note.php?ID=' . $row['ID'] . '">Details</a></td>';
        echo '</tr>';
    } ?>
</table>

<footer>
    <p>© 2023 EFREI - Tous droits réservés</p>
</footer>

</body>
</html>
