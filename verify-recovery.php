<?php 
     require "database.php";
     require "recovery-code.php";


     $form_error = "";
     if(isset($_POST['submit'])){
        //get the data from 6 box in form
         $box_1 = $_POST['box-1'];
         $box_2 = $_POST['box-2'];
         $box_3 = $_POST['box-3'];
         $box_4 = $_POST['box-4'];
         $box_5 = $_POST['box-5'];
         $box_6 = $_POST['box-6'];
 
         $recovery_email = $_SESSION['recovery-email'];
         $verify_code = md5($box_1. $box_2. $box_3. $box_4. $box_5. $box_6); // get the value of 6 input on form then make it hash to match the token generate in database
 
         // check email if already exists
         $chk_recovery_email = "SELECT * FROM employee WHERE email = '$recovery_email'";
         $result = mysqli_query($conn, $chk_recovery_email);
        
         //  use it if u add the expiratio date for reset code
         //  date_default_timezone_set('Asia/Manila');

         if (mysqli_num_rows($result) > 0) {
             
             while($row = mysqli_fetch_assoc($result)) {
                // with expiration token 
                // if ($row['verify_token'] === $verify_code && strtotime($row['expiration_token']) > time())
                 
                 if ($row['reset_code'] === $verify_code) {
                    $_SESSION['recovery-status'] = "valid";
                    
                    header("Location: reset_password.php");
                 }else{
                     $form_error =  "Wrong code or expired";
                     $_SESSION['recovery-status'] = "invalid";
                 }
             }
         } else {
         }
         
        
 
     }
 
     if(isset($_POST['resend-code'])){
        $fullname = $_SESSION['fullname'];
        $email = $_SESSION['recovery-email'];
        $hash_code = md5($reset_code);

        sendmail_reset_password($email, $fullname, $reset_code);

        $update_code = "UPDATE employee SET reset_code = '$hash_code' WHERE email = '$email'";
        $result = mysqli_query($conn, $update_code);

        if($result){
            echo "<script>alert('Verification code has been resent successfully. Please check your email.');</script>";
        }else{
            echo "<script>alert('Failed to resend verification code. Please try again later.');</script>";
        }
    }

   
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recovery Account Authentication</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>
<body class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist flex items-center justify-center">
   
    <!-- logo -->
    <div >
        <img src="assets/r-logo.svg" alt="" class="fixed right-[27rem] top-[2rem]  w-[25%]">
        <div class="border-2 h-[31rem] w-[25%] fixed right-[27rem] top-[2rem]  rounded-full  bg-[#62F3FF] opacity-10 blur-3xl"></div>
    </div>
    <div  class="otp-Form flex flex-col items-center p-10 gap-8 min-w-[30%] h-1/2 rounded-lg shadow-lg border border-[#38373E] backdrop-blur-lg">
        <form method="post" class="flex flex-col items-center gap-8">
            <img src="assets/logo.svg" alt="" class="w-32">

            <div class="text-center leading-9">
                <span class="mainHeading text-3xl font-semibold">Recovery Account Authentication</span>
                <p class="otpSubheading text-center">We have sent a verification code to your registered contact for account recovery</p>
            </div>

            <div class="text-center">
                <!-- error message -->
                <span class="text-red-500 "><?=$form_error;?></span>
                
                <div class="inputContainer flex space-x-3">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent" name="box-1">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent" name="box-2">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent" name="box-3">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent" name="box-4">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent" name="box-5">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent" name="box-6">
                </div>
            </div>

            <button class="verifyButton bg-[#62F3FF] px-4 py-2 rounded-lg hover:bg-[#3DBEC9] font-semibold transition duration-200 text-black" type="submit" name="submit">Verify</button>
            
            
        </form>
        <form action="" method="post">
            <p class="resendNote tracking-wider text-sm">Didn't receive the code? 
                <button class="resendBtn text-[#62F3FF] hover:underline focus:outline-none" type="submit" name="resend-code">Resend Code</button>
            </p>
        </form>
    </div>
</body>
</html>
