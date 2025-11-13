<?php
include "connection.php";

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Delete the workshop record
  $delete = mysqli_query($conn, "DELETE FROM workshop WHERE ownerid='$id'");

  if ($delete) {
    echo "<script>alert('Workshop rejected and deleted successfully'); window.location.href='adminworkshopapproval.php';</script>";
  } else {
    echo "<script>alert('Failed to delete workshop: " . mysqli_error($conn) . "');</script>";
  }
}
?>
