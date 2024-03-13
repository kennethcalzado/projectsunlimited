<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: ../public/login.php"); // Redirect to the login page after logout
exit;
?>