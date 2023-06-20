<?php
    session_start();
    include('dbConn.php');
    if (isset($_SESSION['nom']) == null || isset($_SESSION['ID']) == null || isset($_SESSION['email']) == null || isset($_SESSION['role']) == null){
        header("location: login.php");
    }
    $id = $_SESSION['ID'];
    $nom = $_SESSION['nom'];
    //step1: create a database connection


    $expediteuremail = $_SESSION['email'];
    
    


    if(isset($_POST['btnMessage'])){
        
        $texte = $_POST['txttexte'];
        $destinataireemail = $_POST['txtemail'];
        
        echo "$destinataireemail";
        // Vérifier si le destinataire existe
        $queryexist = "SELECT * FROM user WHERE email = '$destinataireemail'";
        $resultexist = mysqli_query($connection, $queryexist);
        $count = mysqli_num_rows($resultexist);
        if ($count > 0) {
            echo "Le destinataire existe.";
                 // stocker les messages dans la base de données
            $query = "INSERT INTO messages(expediteur_email,destinataire_email,contexte,date_envoi) VALUES('$expediteuremail','$destinataireemail','$texte',NOW())";
            $results = mysqli_query($connection, $query);
            if ($results) {
                echo "Envoie reussi.";
            } else {
                echo "Échec de l'envoi.";
            }
        }
        else {
            echo "Le destinataire n'existe pas.";
        }



    

  

    }
    
 ?>


<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
    <h2>Message a <?php echo "$expediteuremail" ?></h2>
<body>

<?php
            //afficher les messages
            $queryshow = "SELECT * FROM messages WHERE expediteur_email = '$expediteuremail' OR destinataire_email = '$expediteuremail'";
            $resultshow = mysqli_query($connection,$queryshow);
            ?>
            <table border="1" cellspacing='10'>
                <tr>
                    <th>expediteur</th>
                    <th>destinataire</th>
                    <th>message</th>
                    <th>date d'envoi</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($resultshow)){
                    echo '<tr>';
                    echo '<td>'. $row['expediteur_email'] . '</td>';
                    echo '<td>'. $row['destinataire_email'] . '</td>';
                    echo '<td>'. $row['contexte'] . '</td>';
                    echo '<td>'. $row['date_envoi'] . '</td>';
                    echo '</tr>';
                }
            ?>
            </table>    
    


    <form action='' method='post'>

        Destinataire: <input type='text' name='txtemail' required><br>
        Texte: <input type='text' name='txttexte' required><br> 
        <input type='submit' name='btnMessage' value='Envoyer'>
        <input type='reset' name='btnReset' value='Reset'>
    </form>



</body>


