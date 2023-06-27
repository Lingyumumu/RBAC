<?php
//step1: create a database connection
include '../../dbConn.php';
/*if (isset($_SESSION['role']) != 'administrateur' ){
    header("location: ../login.php");
}*/

if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $prenom . "." . $nom . "@efrei.fr";
    $mdp = $_POST['txtmdp'];
    $role = $_POST['txtrole'];
    $formation = $_POST['txtformation'];

        
    // Check if password and confirmation are the same
    if ($_POST['txtmdp'] != $_POST['txtmdp2']) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

 // Check if user already exists
$querysame = "SELECT * FROM user WHERE email = '$email'";
$resultsame = mysqli_query($connection, $querysame);
$count = mysqli_num_rows($resultsame);

 // Check if user already exists
    if ($count > 0) {
        echo "Un compte avec cet email existe déjà.";
    }
    else {
        $query = "INSERT INTO user(nom,prenom,email,password,role,statut,formation) VALUES('$nom','$prenom','$email','$mdp','$role','validé','$formation')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            $_SESSION['txtemail'] = $email;
            //include('email\awpreg.php');
            echo "Succès réussie.";
            echo "<a href='list_user.php'>Aller à la page principale</a><br>";
        } else {
            echo "Échec de la création de compte.";
        }
    }
}

echo "<a href='list_user.php'>liste de user</a><br>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>

<body>
    <h2>Registration page</h2>
    <form action='' method='post'>
    
        Nom: <input type='text' name='txtnom' required><br>
        Prenom: <input type='text' name='txtprenom' required><br>
        Intitule de la formation: <select name='txtformation' required><br>
        <?php
        $queryf = "SELECT * FROM formations";
        $resultsf = mysqli_query($connection, $queryf);
        while ($row = mysqli_fetch_array($resultsf)) {
            echo "<option value='" . $row['nom'] . "'>" . $row['nom'] . "</option>";
        }
        ?>
        </select><br>
        Mot de passe: <input type='password' name='txtmdp' required><br>
        Confirmation mot de passe: <input type='password' name='txtmdp2' required><br>
        Role : <select name='txtrole'>
            <option value='administrateur'>Administrateur</option>
            <option value='personnel'>Personnel</option>
            <option value='professeur'>Professeur</option>
            <option value='etudiant'>Etudiant</option>
        <input type='submit' name='btnRegister' value='Register'>
    
    </form>
</body>
</html>

