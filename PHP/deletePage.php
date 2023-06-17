<?php 
include 'dbConn.php';
$id = $_GET['ID'];
$query = "DELETE FROM user WHERE ID = $id";
if(mysqli_query($connection, $query)){
    header("Location: Administrateur/liste_utilisateur.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>