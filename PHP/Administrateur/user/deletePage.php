<?php 
include '../../dbConn.php';
session_start();
$id = $_GET['ID'];
if ($_SESSION['role'] != 'administrateur') {
    header("location: ../../login.php");
}
$querynom = "SELECT * FROM user WHERE ID = '$id'";
$resultnom = mysqli_query($connection, $querynom);
$rownom = mysqli_fetch_assoc($resultnom);

$queryprof = "DELETE FROM cours WHERE nom_prof = '$rownom[nom]'";
$resultprof = mysqli_query($connection, $queryprof);
$query = "DELETE FROM user WHERE ID = $id";
if(mysqli_query($connection, $query)){
    header("location: list_user.php");
}
else{
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}
mysql_close($connection);
?>