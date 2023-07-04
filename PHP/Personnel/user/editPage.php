<?php
include ('../../dbConn.php');
$id = $_GET['ID'];
if (isset($_GET['ID']) == null ){
    header("location: list_user.php");
}

if (isset($_POST['btnUpdate'])){
    $nom = $_POST['txtnom'];
    $prenom = $_POST['txtprenom'];
    $email = $_POST['txtemail'];
    $password = $_POST['txtmdp'];
    $role = $_POST['txtrole'];
    $formation = $_POST['txtformation'];

    if($role == 'administrateur' || $role == 'personnel'){
        $updateQuery = "UPDATE user SET nom = '$nom', prenom = '$prenom', email = '$email', password = '$password', role= '$role', formation = '' WHERE id = '$id'";
    }
    else{
        $updateQuery = "UPDATE user SET nom = '$nom', prenom = '$prenom', email = '$email', password = '$password', role= '$role', formation = '$formation' WHERE id = '$id'";
    }
    
    $resultQuery = mysqli_query($connection, $updateQuery);
    if($resultQuery){
        echo "the user has been updated<br>";
        header("Location: list_user.php");
    }
    else{
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
    <link rel="stylesheet" href="../../Administrateur/user/editPage.css">
    <title></title>
</head>
<body>
    <h1>Page de modification</h1>
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
        Nom de Formation (vide pour personnel et administrateur): <select name="txtformation">
            <option value="<?php echo $row1['nom'] ?>"><?php echo $row1['nom'] ?></option>
            <option value='' >(vide)</option>
        </select>
        <br><br>
        <input type='submit' name='btnUpdate' value='Mettre à jour'>
    </form>
    <br><br>
    <a href='list_user.php'>Aller à la page principale</a>
</body>
</html>
