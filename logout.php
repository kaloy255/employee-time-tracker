<?php 

  function pathTo($destination) {
    echo "<script>window.location.href ='/employee-time-tracker/$destination.php'</script>";
  }

  session_start();

  /* Set status to invalid */
  $_SESSION['status'] = 'invalid';

  /* Unset user data */
  unset($_SESSION['username']);

  /* Redirect to login page */
  pathTo('login');
?>