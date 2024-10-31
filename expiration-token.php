
<!-- delete the acc if expired the token -->
<?php

    require "database.php";

    date_default_timezone_set('Asia/Manila');
    $expiration = date("Y-m-d H:i:s");
    var_dump($expiration);

    // check if have non verified and expired there token
    $chk_query = "SELECT * FROM employee WHERE expiration_token <  '$expiration' AND verified = ''";
    $result = mysqli_query($conn, $chk_query);

    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            // get the id of expired token and non verified
            $userId = (int)$row['id'];
            // then delete it
            $delete_query = "DELETE FROM employee WHERE id = $userId";
            mysqli_query($conn, $delete_query);
        }
      } else {
        echo "0 results";
      }
      
      mysqli_close($conn);
        
  
