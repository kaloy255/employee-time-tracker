<?php
    session_start();
    require "database.php";
    require "sendmail.php";

    //form error message
    if(isset($_POST['send_email_btn'])){
        $email = $_POST['email'];

   
        $chk_email = "SELECT email, fullname, reset_code FROM employee WHERE email = '$email' AND verified = 'yes'";
        $result = mysqli_query($conn, $chk_email);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                //get the fullname of employee base on email insert t osession variable
                $_SESSION['fullname'] = $row['fullname'];
                // resign this to variable
                $fullname = $_SESSION['fullname'];

                // convert into hash alphanumeric the aot code for recovery
                $hash_code = md5($reset_code);
                $_SESSION['recovery-email'] = $email;
                
                //send the aot code on email of employee
                sendmail_reset_password($email,$fullname, $reset_code);

                // insert the recovery aot code 
                $insert_reset_code = "UPDATE employee SET reset_code = '$hash_code' WHERE email = '$email'";
                mysqli_query($conn, $insert_reset_code);

                $_SESSION['recovery-message'] = " ";
                header("Location: verify-recovery.php");
                
            }

           
        } else {
            $_SESSION['recovery-message'] =  "Invalid email please use your email already registered";
            header("Location: recovery.php");
        }


    }
?>