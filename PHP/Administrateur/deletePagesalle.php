<?php
include '../dbConn.php';
$id = $_GET['ID'];
$query = "DELETE FROM salles WHERE ID = $id";
if(mysqli_query($connection, $query)){
    header("Location: list_salle.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>