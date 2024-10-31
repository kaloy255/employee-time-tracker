<?php 


  if ($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
    /* Set status to invalid */
    $_SESSION['status'] = 'invalid';

    /* Unset user data */
    unset($_SESSION['username']);

    /* Redirect to login page */
    pathTo('login');
  }

  
?>