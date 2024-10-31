<?php
    session_start();
    require "database.php";
    
   
 
  
    if(isset($_POST['submit'])){
        $box_1 = $_POST['box-1'];
        $box_2 = $_POST['box-2'];
        $box_3 = $_POST['box-3'];
        $box_4 = $_POST['box-4'];
        $box_5 = $_POST['box-5'];
        $box_6 = $_POST['box-6'];

        $userId =  $_SESSION['id']; // User's ID
        $verify_code = md5($box_1. $box_2. $box_3. $box_4. $box_5. $box_6); // get the value of 6 input on form then make it hash to match the token generate in database

            // Prepare and execute the SQL query
        $sql = "SELECT * FROM employee WHERE id = $userId";
        $result = mysqli_query($conn, $sql);
        
        date_default_timezone_set('Asia/Manila');
        if (mysqli_num_rows($result) > 0) {
            
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                
                if ($row['verify_token'] === $verify_code && strtotime($row['expiration_token']) > time()) {
                    $update_query = "UPDATE employee set verified = 'yes' WHERE id = $userId";
                    mysqli_query($conn, $update_query);
                    $_SESSION['status'] = 'valid';
                    $_SESSION['fullname'] = $row['fullname'];
                    header("Location: login.php");
                }else{
                    echo "failed";
                }
            }
        } else {
            echo "0 results";
        }
        
        mysqli_close($conn);
       

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
</head>
<body class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist flex items-center justify-center">
   

    <!-- logo -->
    <div>
        <img src="assets/r-logo.svg" alt="" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-30">
        <div class="border-2 h-[840px] w-[840px] fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  rounded-full  bg-[#62F3FF] opacity-5 blur-3xl"></div>
    </div>


    <form class="otp-Form flex flex-col justify-center items-center p-10  gap-8 min-w-[30%] h-1/2  rounded-lg shadow-lg border border-[#38373E] backdrop-blur-lg" method="post">
        <img src="assets/logo.svg" alt="" class="w-32">

    <div class="text-center leading-9">
        <span class="mainHeading text-3xl font-semibold">Enter OTP</span>
        <p class="otpSubheading  text-center">We have sent a verification code to your mobile number</p>
    </div>
    <div>
        <!-- <?php if (empty($error)) : ?>
        <span class="text-green-500"><?=$success?></span>
        <?php else : ?>
        <span class="text-red-500"><?= $error ?></span>
        <?php endif; ?> -->
      

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
    
   
    
    <p class="resendNote tracking-wider text-sm">Didn't receive the code? 
        <button class="resendBtn text-[#62F3FF]  hover:underline focus:outline-none">Resend Code</button>
    </p>
    </form>

</body>
</html>