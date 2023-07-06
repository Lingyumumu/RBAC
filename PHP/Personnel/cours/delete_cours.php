<?php 
session_start();
include ('../../dbConn.php');
if ($_SESSION['role'] != 'personnel') {
    header("location: ../../login.php");
}
$id = $_GET['ID'];
$querynote = "DELETE FROM notes WHERE id_cours = $id";
$query = "DELETE FROM cours WHERE ID = $id";

if(mysqli_query($connection, $querynote)){
    if(mysqli_query($connection, $query)){
        header("Location: list_formation.php");
    }
    else{
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>