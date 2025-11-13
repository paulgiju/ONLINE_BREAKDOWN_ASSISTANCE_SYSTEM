<?php
include "connection.php";
session_start();

$reqno = $_GET['id'];
$wid = $_SESSION['id'];

mysqli_query($conn, "UPDATE booking SET status='Accepted' WHERE reqno='$reqno'");

$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT uid, wid FROM booking WHERE reqno='$reqno'"));
$uid = $booking['uid'];

$wname = mysqli_fetch_assoc(mysqli_query($conn, "SELECT wname FROM workshop WHERE ownerid='$wid'"))['wname'];
$now = date("Y-m-d H:i:s");
$msg = "$wname has accepted your service request. Assistance is on the way.";
mysqli_query($conn, "INSERT INTO notifications (uid, message, created_at) VALUES ('$uid', '$msg', '$now')");

$title = "Request Accepted";
$message = "You accepted Request #$reqno.";
$type = "status";
$icon = "fas fa-check-circle";
mysqli_query($conn, "
  INSERT INTO workshop_notification (wid, title, message, type, icon)
  VALUES ('$wid', '$title', '$message', '$type', '$icon')
");

header("Location: workshophpage.php?msg=accepted");
?>
