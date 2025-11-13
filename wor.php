<?php
include "connection.php";
session_start();

$reqno = $_GET['id'];
$wid = $_SESSION['id'];

mysqli_query($conn, "UPDATE booking SET status='Rejected' WHERE reqno='$reqno'");

// Notification for workshop owner
$title = "Request Rejected";
$message = "You rejected Request #$reqno.";
$type = "status";
$icon = "fas fa-times-circle";

mysqli_query($conn, "
  INSERT INTO workshop_notification (wid, title, message, type, icon)
  VALUES ('$wid', '$title', '$message', '$type', '$icon')
");

header("Location: workshophpage.php?msg=rejected");
?>
