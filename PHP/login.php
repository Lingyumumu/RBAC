<?php
    session_start();
    //step1: create a database connection
    include('dbConn.php');
    
    

    if(isset($_POST['btnLogin'])){
        $email = $_POST['txtemail'];
        $password = $_POST['txtmdp'];
        $query = "SELECT * FROM user WHERE email = '$email' AND password = '$password' AND statut = 'validé'";
        $queryfailed = "SELECT * FROM user WHERE email = '$email' AND password != '$password'";
        //$query = "SELECT * FROM tblstudents WHERE Username = '$username' AND password = '$password'";
        $results = mysqli_query($connection,$query);
        $row = mysqli_fetch_assoc($results);
        $count = mysqli_num_rows($results);

        $resultsfailed = mysqli_query($connection,$queryfailed);
        $rowfailed = mysqli_fetch_assoc($resultsfailed);
        $countfailed = mysqli_num_rows($resultsfailed);



        if($count == 1){
            echo '<br>User Exists in the database';
            //start a session
            //$_SESSION['nom'] = $row['prenom'] . ' ' . $row['nom'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];
            $_SESSION['ID'] = $row['ID'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['formation'] = $row['formation'];
            //header("location: Etudiant/mes_absences.php");
            //header("location: Etudiant/notes/list_note.php");
            //header("location: Etudiant/plannings/list_planning.php");
            //header("location: Professeur/cours_assigner.php");
            //header("location: Etudiant/cours_inscrit.php");
            //header("location: Administrateur_nael/document/list_documents.php");
            //header("location: Administrateur/document/list_documents.php");
            //redirect the user 
            
            if($_SESSION['role'] == 'etudiant'){
                header("location: Etudiant/Home_Etudiant.php");
            }
            if($_SESSION['role'] == 'professeur' ){
                header("location: Professeur/Home_Professeur.php");
            }
            if($_SESSION['role'] == 'personnel'){
                header("location: Personnel/Home_Personnel.php");
            }
            if ($_SESSION['role'] == 'administrateur') {
                header("location: Administrateur/Home_Admin.php");
            }
            
        } elseif($countfailed == 1){
            echo '<br>Mot de passe incorrect';
        }

        else{
            echo '<br>User does not exist in the database';
        } 
        

        
        /*if($username == 'admin' && $password == '123456'){
            $_SESSION['username'] = $username;
            header('location: index.php');
        }else{
            echo 'Login failed';
        }*/
        
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
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="" method="post">
            <input type="text" name="txtemail" placeholder="Adresse Mail" required><br>
            <input type="password" name="txtmdp" placeholder="Mot de passe" required><br>
            <input type="submit" name="btnLogin" value="Connexion">
        </form>
        <p>Vous n'avez pas de compte ? <a href="register.php">Créer un compte</a></p>
    </div>
</body>
</html>

