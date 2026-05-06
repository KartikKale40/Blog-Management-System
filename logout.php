<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();


 echo "<script>alert('Logout Successfully');</script>";

// Redirect to index.html after logout
header("Location: index.php");
exit();
?>