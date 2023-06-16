<?php
session_start();
//step1: create a database connection
include('dbConn.php');
$lastRIDQuery = "SELECT MAX(RID) as maxRID FROM user";
$lastRIDResult = mysqli_query($connection, $lastRIDQuery);
$lastRIDRow = mysqli_fetch_assoc($lastRIDResult);
$lastRID = $lastRIDRow['maxRID'];
if ($lastRID > 40000) {
    $nextRID = $lastRID + 1;
} else {
    $nextRID = 40000;
}


if(isset($_POST['btnRegister'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $prenom . "." . $nom . "@efrei.fr";
    $mdp = $_POST['txtmdp'];
    $query = "INSERT INTO user(nom,prenom,email,password,RID) VALUES('$nom','$prenom','$email','$mdp','$nextRID')";
    $results = mysqli_query($connection,$query);
    if($results){
        $_SESSION['txtemail'] = $email;


        //include('email\awpreg.php');
        echo "Registration successful, we send you a confirmation email";
        echo "<a href='index.php'>Go to main page</a>";
    }
    else{
        echo "Registration failed"; 
    }   
}
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
        mot de passe: <input type='password' name='txtmdp' required><br>
        <input type='submit' name='btnRegister' value='Register'>
    </form>
</body>
</html>

