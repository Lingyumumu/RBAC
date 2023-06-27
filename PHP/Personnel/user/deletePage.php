<?php 
include '../../dbConn.php';
$id = $_GET['ID'];
if (isset($_GET['ID']) == null ){
    header("location: list_user.php");
}
$query = "DELETE FROM user WHERE ID = $id";
if(mysqli_query($connection, $query)){
    header("location: list_user.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>