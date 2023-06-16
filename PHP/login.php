<?php
    session_start();
    //step1: create a database connection
    include('dbConn.php');
    

    if(isset($_POST['btnLogin'])){
        $email = $_POST['txtemail'];
        $password = $_POST['txtmdp'];
        $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        //$query = "SELECT * FROM tblstudents WHERE Username = '$username' AND password = '$password'";
        $results = mysqli_query($connection,$query);
        $row = mysqli_fetch_assoc($results);
        $count = mysqli_num_rows($results);
        if($count == 1){
            echo '<br>User Exists in the database';
            //start a session
            $_SESSION['name'] = $row['prenom'] . ' ' . $row['nom'];
            $_SESSION['ID'] = $row['ID'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['RID'] = $row['RID'];

            //redorect the user 

            if($_SESSION['RID'] >= 1 && $_SESSION['RID'] <= 9999){
                header("location: ../PHP/Etudiant/Home_Etudiant.php");
            }
            if($_SESSION['RID'] >= 10000 && $_SESSION['RID'] <= 19999){
                header("location: ../PHP/Professeur/Home_Professeur.php");
            }
            if($_SESSION['RID'] >= 20000 && $_SESSION['RID'] <= 29999){
                header("location: ../PHP/Personnel_Admin/Home_Personnel_Admin.php");
            }
            if ($_SESSION['RID'] <= 40000) {
                header("location: ../PHP/Administrateur/Home_Admin.php");
            }
            } else {
                header("location: index.php");
            }

        
        /*if($username == 'admin' && $password == '123456'){
            $_SESSION['username'] = $username;
            header('location: index.php');
        }else{
            echo 'Login failed';
        }*/
    }
    else{
        echo '<br>User does not exist in the database';
    }
    mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <h1>Login</h1>
    <form action="" method="post">
        <input type="text" name="txtemail" placeholder="Adresse Mail"><br>
        <input type="password" name="txtmdp" placeholder="Mot de passe"><br>
        <input type="submit" name="btnLogin" value="Connexion">
    </form>
    <br>
    <p>
        Click<a href="register.php"> here </a> if you do not have an account
    </p>
</body>
</html>
