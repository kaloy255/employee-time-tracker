<?php

session_start();
if ($_SESSION['recovery-status'] == 'invalid' || empty($_SESSION['recovery-status'])) {
    /* Set status to invalid */
    $_SESSION['recovery-status'] = 'invalid';


    /* Redirect to login page */
    header("Location: recovery.php");
  }
