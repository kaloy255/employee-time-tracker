<?php 
  session_start();

  function pathTo($destination) {
    echo "<script>window.location.href ='/employee-time-tracker/$destination.php'</script>";
  }

  /* Unset user data */
  unset($_SESSION['email']);
  
  $_SESSION['status'] = "invalid";

  /* Redirect to login page */
  pathTo('login');
?>