<?php
include('../../dbConn.php');
session_start();
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}
$id = $_GET['ID'];
if (isset($_GET['ID']) == null) {
    header("location: list_user.php");
}

if (isset($_POST['btnUpdate'])) {
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $_POST['txtemail'];
    $password = $_POST['txtmdp'];
    $role = $_POST['txtrole'];
    $formation = $_POST['txtformation'];

    if ($role == 'administrateur' || $role == 'personnel') {
        $updateQuery = "UPDATE user SET nom = '$nom', prenom = '$prenom', email = '$email', password = '$password', role= '$role', formation = '' WHERE id = '$id'";
    } else {
        $updateQuery = "UPDATE user SET nom = '$nom', prenom = '$prenom', email = '$email', password = '$password', role= '$role', formation = '$formation' WHERE id = '$id'";
    }

    $resultQuery = mysqli_query($connection, $updateQuery);
    if ($resultQuery) {
        echo "the user has been updated<br>";
        header("Location: list_user.php");
    } else {
        echo "the user has not been updated<br>";
    }
}

$query = "SELECT * FROM user WHERE ID = $id";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$queryformation = "SELECT * FROM formations";
$resultformation = mysqli_query($connection, $queryformation);
$row1 = mysqli_fetch_assoc($resultformation);



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="editPage.css">
</head>

<body>
    <header>
        <h1>Page de modification</h1>
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

    <form action='' method='post'>
        Nom: <input type='text' name='txtnom' value="<?php echo $row['nom'] ?>" required><br>
        Prénom: <input type='text' name='txtprenom' value="<?php echo $row['prenom'] ?>" required><br>
        Email: <input type='email' name='txtemail' value='<?php echo $row['email'] ?>' required><br>
        Mot de passe: <input type='text' name='txtmdp' value='<?php echo $row['password'] ?>' required><br>
        Role: <select name='txtrole' value='<?php echo $row['role'] ?>'>
            <option value='administrateur'>Administrateur</option>
            <option value='personnel'>Personnel</option>
            <option value='professeur'>Professeur</option>
            <option value='etudiant'>Etudiant</option>
        </select>
        <br>
        Formation: <select name='txtformation' value='<?php echo $row['formation'] ?>'>
        <?php
            $queryf = "SELECT * FROM formations";
            $resultsf = mysqli_query($connection, $queryf);
            while ($row = mysqli_fetch_array($resultsf)) {
                echo "<option value='" . $row['nom'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
        </select>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='list_user.php'>Aller à la page principale</a>
    <footer>
        <p>© 2023 EFREI - Tous droits réservés</p>
    </footer>
</body>
</html>