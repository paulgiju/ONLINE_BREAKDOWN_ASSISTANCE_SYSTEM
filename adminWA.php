<?php
include 'connection.php';
$id = $_GET['id'];
mysqli_query($conn, "UPDATE workshop SET rights = 'W' WHERE ownerid = '$id'");
header("Location: adminworkshopapproval.php");
?>
