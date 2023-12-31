<?php
//step1: create a database connection
include('../../dbConn.php');
session_start();
if ($_SESSION['role'] != 'personnel') {
    header("location: ../../login.php");
}

// Vérifier si une action d'update a été soumise
if (isset($_POST['btnUpdate'])) {
    $id = $_POST['userID'];
    $statut = $_POST['statut'];

    // Vérifier si le statut est "refusé"
    if ($statut === "refuser") {
        // Supprimer l'utilisateur de la table user
        $queryDelete = "DELETE FROM user WHERE ID = '$id'";
        $resultDelete = mysqli_query($connection, $queryDelete);

        if ($resultDelete) {
            echo "Utilisateur supprimé avec succès.";
        } else {
            echo "Échec de la suppression de l'utilisateur.";
        }
    } else {
        // Exécuter la requête de mise à jour
        $queryUpdate = "UPDATE user SET statut = '$statut' WHERE ID = '$id'";
        $resultUpdate = mysqli_query($connection, $queryUpdate);

        if ($resultUpdate) {
            echo "Mise à jour réussie.";
        } else {
            echo "Échec de la mise à jour.";
        }
    }
}
echo '<a href="../../index.php">Retour</a>';
?>

<!Doctype html>
<html>

<head>
    <title>Document</title>
    <link rel="stylesheet" href="list_register.css">
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

    <h2>Admin Students Details</h2>
    <?php

    //step3: execute the query
    
    $query = "SELECT * FROM user";
    $results = mysqli_query($connection, $query);
    ?>
    <table border="1" cellspacing='10'>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Mot de passe</th>
            <th>Rôle</th>
            <th>Statut</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)) {
            echo '<tr>';
            echo '<td>' . $row['ID'] . '</td>';
            echo '<td>' . $row['nom'] . '</td>';
            echo '<td>' . $row['prenom'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['password'] . '</td>';
            echo '<td>' . $row['role'] . '</td>';
            echo '<td>' . $row['statut'] . '</td>';
            echo '<td>
                    <form action="" method="post">
                        <input type="hidden" name="userID" value="' . $row['ID'] . '">
                        <select name="statut">
                            <option value="valide">validé</option>
                            <option value="refuser">refusé</option>
                        </select>
                        <input type="submit" name="btnUpdate" value="Mettre à jour">
                    </form>
                </td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>

<footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>

</html>