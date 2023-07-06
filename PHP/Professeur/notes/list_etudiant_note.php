<?php
//step1: create a database connection
include ('../../dbConn.php');
session_start();


if ($_SESSION['role'] != 'professeur') {
    header("location: ../../login.php");
}
?>


<!Doctype html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="list_etudiant_note.css">
    <style>
        footer{
        text-align: center;
        }
    </style>

</head>
<body>

<header>
    <h1>Système de Gestion - EFREI</h1> 
</header>

<nav>
    <ul>
    <li><a href="../Home_Professeur.php">Accueil</a></li>
    <li><a href="list_etudiant_note.php">Notes</a></li>
        <li><a href="../cours_assigner.php">Document</a></li>
        <li><a href="../plannings/list_planning.php">Plannings</a></li>
        <li><a href="../../Message.php">Message</a></li>
        <li><a href="../../logout.php">Deconnexion</a></li>
    </ul>
</nav>

<form action="#" method="get">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" placeholder="Nom">
    
    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" placeholder="Prénom">
    
    <label for="role">Rôle:</label>
    <select id="" name="role" placeholder="Rôle">
        <option value="">vide</option>
        <option value="administrateur">Administrateur</option>
        <option value="personnel">Personnel</option>
        <option value="professeur">Professeur</option>
        <option value="étudiant">Etudiant</option>
    </select>
    
    <label for="statut">Statut:</label>
    <select id="" name="statut" placeholder="Statut">
        <option value="">vide</option>
        <option value="validé">Validé</option>
        <option value="en attente">En attente</option>
    </select>
    
    <input type="submit" value="filtré" name="btnSend">
    <input type="reset" value="effacer">
</form>

    <h2>Admin Students Details</h2>
    <?php
    //step2: create a database query

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $conditions = array();
    
        if (!empty($_GET['nom'])) {
            $nom = $_GET['nom'];
            $conditions[] = "nom LIKE '%$nom%'";
        }
    
        if (!empty($_GET['prenom'])) {
            $prenom = $_GET['prenom'];
            $conditions[] = "prenom LIKE '%$prenom%'";
        }
    
        if (!empty($_GET['role'])) {
            $role = $_GET['role'];
            $conditions[] = "role = '$role'";
        }
    
        if (!empty($_GET['statut'])) {
            $statut = $_GET['statut'];
            $conditions[] = "statut = '$statut'";
        }
    
        // Ajouter la condition pour filtrer uniquement les utilisateurs avec le rôle 'etudiant'
        $conditions[] = "role = 'etudiant'";
    
        // Construire la clause WHERE en combinant les conditions
        $whereClause = "";
        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }
    
        // Exécuter la requête avec la clause WHERE appropriée
        $query = "SELECT * FROM user $whereClause";
        $results = mysqli_query($connection, $query);
    }

            
    //step3: execute the query
    echo '<a href="create_note.php">Ajouter une note</a>';
    ?>
    <table border="1" cellspacing='10'>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Formation</th>
            <th>Details</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($results)){
            echo '<tr>';
            echo '<td>'. $row['nom'] . '</td>';
            echo '<td>'. $row['prenom'] . '</td>';
            echo '<td>'. $row['formation'] . '</td>';
            echo '<td><a href="list_note.php?ID=' . $row['ID'] . '">Details</a></td>';
            echo '</tr>';
        }
    ?>
    </table>
<footer>
    <p>© 2023 EFREI - Tous droits réservés</p>
</footer>
    </body>
    </html>