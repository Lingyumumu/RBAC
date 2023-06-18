<?php 
include '../dbConn.php';
$id = $_GET['ID'];
$query = "DELETE FROM etude WHERE ID = $id";

if(mysqli_query($connection, $query)){

    header("Location: list_cours.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>