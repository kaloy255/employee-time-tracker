<?php
    session_start();
    require "database.php";
    require "sendmail.php";
    date_default_timezone_set('Asia/Manila');

    $code_error = "";
    // submit verify code
    if(isset($_POST['submit'])){
        $box_1 = $_POST['box-1'];
        $box_2 = $_POST['box-2'];
        $box_3 = $_POST['box-3'];
        $box_4 = $_POST['box-4'];
        $box_5 = $_POST['box-5'];
        $box_6 = $_POST['box-6'];

        $userId =  $_SESSION['id']; // User's ID
        $verify_code = md5($box_1. $box_2. $box_3. $box_4. $box_5. $box_6); // get the value of 6 input on form then make it hash to match the token generate in database

       
        // check email if already exists
        $sql = "SELECT * FROM employee WHERE id = $userId";
        $result = mysqli_query($conn, $sql);
       
   
        if (mysqli_num_rows($result) > 0) {
            
            while($row = mysqli_fetch_assoc($result)) {
                
                if ($row['verify_token'] === $verify_code && strtotime($row['expiration_token']) > time()) {
                    $update_query = "UPDATE employee set verified = 'yes' WHERE id = $userId";
                    mysqli_query($conn, $update_query);
                    // change
                    // $_SESSION['fullname'] = $row['fullname'];
                    session_destroy();
                    echo "<script>alert('Successfull Verify');</script>";
                    header("Location: login.php");
                }else{
                    $code_error =  "Wrong code or expired";
                }
            }
        } else {
            echo "0 results";
        }
        
        mysqli_close($conn);
       

    }
    

    // Set cooldown period in seconds (3 minutes)
    $cooldown_period = 180;
    $remaining_time = 0;

    // Check if the resend code button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resend-code'])) {
         
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
        $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
        $expiration = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        $current_time = time();
        $last_resend_time = $_SESSION['last_resend_time'] ?? 0;

        if($user_id == "" || $fullname == "" || $email == ""  ){
            $code_error = "Please register first or you already registered ";
        }
        // Check if the cooldown period has elapsed
        elseif ($current_time - $last_resend_time >= $cooldown_period) {
            // Update last resend time in the session
            $_SESSION['last_resend_time'] = $current_time;

            // Simulate resend logic here (replace with actual resend function)
            sendmail_verify($email, $fullname, $verificationCode);
            $hash_code = md5($verificationCode);

            $update_code = "UPDATE employee SET verify_token = '$hash_code', expiration_token = '$expiration' WHERE id = $user_id";
            $result = mysqli_query($conn, $update_code);

            if($result){
                echo "<script>alert('Verification code has been resent successfully. Please check your email.');</script>";
            }else{
                echo "<script>alert('Failed to resend verification code. Please try again later.');</script>";
            }
      
        } else {
            // Calculate remaining time for cooldown
            $remaining_time = $cooldown_period - ($current_time - $last_resend_time);
        }
    } else {
        // If page is loaded without a POST request, calculate remaining time based on last resend time
        $current_time = time();
        $last_resend_time = $_SESSION['last_resend_time'] ?? 0;
        if ($current_time - $last_resend_time < $cooldown_period) {
            $remaining_time = $cooldown_period - ($current_time - $last_resend_time);
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verficiation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>
<body class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist flex items-center justify-center">
   

    <!-- logo -->
    <div>
        <img src="assets/r-logo.svg" alt="" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-30">
        <div class="border-2 h-[840px] w-[840px] fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  rounded-full  bg-[#62F3FF] opacity-5 blur-3xl"></div>
    </div>

    <div class="otp-Form flex flex-col items-center p-10  gap-8 min-w-[30%] h-1/2  rounded-lg shadow-lg border border-[#38373E] backdrop-blur-lg">
        <form  method="post" class = "flex  flex-col items-center gap-8">
            <img src="assets/logo.svg" alt="" class="w-32">

            <div class="text-center leading-9">
                <span class="mainHeading text-3xl font-semibold">Enter OTP</span>
                <p class="otpSubheading  text-center">We have sent a verification code to your mobile number</p>
            </div>

            <div class="text-center">
                <!-- error message -->
                <span class="text-red-500 "><?= $code_error; ?></span>
                
                <div class="inputContainer flex space-x-3 ">
                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent"
                    name="box-1">

                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent"
                    name="box-2">

                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent"
                    name="box-3">

                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent"
                    name="box-4">

                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent"
                    name="box-5">

                    <input required maxlength="1" type="text" class="otp-input w-12 h-12 text-center border border-[#999999] rounded-lg focus:outline-none focus:border-2 focus:border-[#62F3FF] bg-transparent"
                    name="box-6">
                    
                </div>
            </div>

            <button class="verifyButton bg-[#62F3FF] px-4 py-2 rounded-lg hover:bg-[#3DBEC9] font-semibold transition duration-200 text-black" type="submit" name="submit">Verify</button>
        </form>
      
        <form method="POST" action="">
            <p class="resendNote tracking-wider text-sm">Didn't receive the code? 
            <button type="submit" name="resend-code" id="resendButton" class="resendBtn text-[#62F3FF]  hover:underline focus:outline-none">Resend Verification Code</button>
            </p>
            <p id="timerDisplay" style="color: red;"></p> <!-- Timer display area -->
        </form>

    </div>

</body>


<script>
    // JavaScript Countdown Timer
    let remainingTime = <?php echo $remaining_time; ?>; // Get remaining time from PHP

    function updateTimer() {
        const button = document.getElementById('resendButton');
        const timerDisplay = document.getElementById('timerDisplay');

        if (remainingTime > 0) {
            button.disabled = true;
            button.innerText = `Resend Verification Code (${remainingTime} seconds)`;
            timerDisplay.innerText = `You can resend the code in ${remainingTime} seconds.`;
            remainingTime--;

            // Call updateTimer every second
            setTimeout(updateTimer, 1000);
        } else {
            button.disabled = false;
            button.innerText = "Resend Verification Code";
            timerDisplay.innerText = ""; // Clear timer message
        }
    }

    // Start the countdown if there is remaining time
    window.onload = function() {
        if (remainingTime > 0) {
            updateTimer();
        }
    };
    </script>
</html>