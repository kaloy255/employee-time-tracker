<?php 
  session_start();
  if ($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
    /* Set status to invalid */
    $_SESSION['status'] = 'invalid';

    /* Unset user data */
    session_destroy();

    /* Redirect to login page */
    header("Location: login.php");
  }
  
?>