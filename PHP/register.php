<?php
//step1: create a database connection
include('dbConn.php');

$queryformation = "SELECT * FROM formations";
$resultformation = mysqli_query($connection, $queryformation);

// Fetch all formations into an array
$formations = array();
while ($row = mysqli_fetch_assoc($resultformation)) {
    $formations[] = $row;
}

if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $prenom . "." . $nom . "@efrei.fr";
    $mdp = $_POST['txtmdp'];
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
    } else {
        $query = "INSERT INTO user(nom,prenom,email,password,role,statut,formation) VALUES('$nom','$prenom','$email','$mdp','etudiant','en attente','$formation')";
        $results = mysqli_query($connection, $query);
        if ($results) {
            $_SESSION['txtemail'] = $email;
            //include('email\awpreg.php');
            echo "Inscription réussie, nous vous avons envoyé un email de confirmation.";
            echo "<a href='index.php'>Aller à la page principale</a>";
        } else {
            echo "Échec de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
<form action='' method='post'>
    <h2>Registration page</h2>
    Nom: <input type='text' name='txtnom' required><br>
    Prenom: <input type='text' name='txtprenom' required><br>
    Formation: <select name="txtformation">
        <?php foreach ($formations as $formation) { ?>
            <option value="<?php echo $formation['nom'] ?>"><?php echo $formation['nom'] ?></option>
        <?php } ?>
    </select><br>
    Mot de passe: <input type='password' name='txtmdp' required><br>
    Confirmation mot de passe: <input type='password' name='txtmdp2' required><br>
    <input type='submit' name='btnRegister' value='Register'>
    <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>
</form>
</body>
</html>
