<?php 
    require "database.php";
    require "session_reset_password.php";

    $pass_error = "";
    $past_password_error = "";
    if(isset($_POST['change_password'])){
        $password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_new_password']);
        $email = $_SESSION['recovery-email'];

        //check the new password if follow the rules in password form
        $chk_password = $_POST['new_password'];
        $chk_cpassword = $_POST['confirm_new_password'];
        if (!preg_match('/[A-Za-z]/', $chk_password) || !preg_match('/\d/', $chk_cpassword)) {
            $pass_error = "Password must contain at least one letter and one number.";
        }elseif($chk_password !== $chk_cpassword){
            $pass_error = "Passwords do not match.";   
        }


        if(empty($pass_error)){

            // retrieve the password base on email recovery
            $query_chk_password = "SELECT `password` FROM employee WHERE email = '$email'";
            $result = mysqli_query($conn, $query_chk_password);

            
            if (mysqli_num_rows($result) > 0) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    $past_password = $row['password'];
                    // check the password if match the current password in database
                    if($past_password === $password){
                        $past_password_error = "Your new password cannot be the same as your current password. Please choose a different password.";


                    }else{
                        // update the employee password
                        $update_password = "UPDATE employee SET `password` = '$password' WHERE email = '$email'";
                        mysqli_query($conn, $update_password);
                        header("Location: login.php");
                    }
                
                }
            } 
        
        }
        


    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
</head>
<body class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative   text-white urbanist flex justify-center items-center">
    
    <div >
        <img src="assets/r-logo.svg" alt="" class="fixed right-[28rem] top-[2rem]  w-[25%]">
        <div class="border-2 h-[30rem] w-[25%] fixed right-[28rem] top-[2rem]  rounded-full  bg-[#62F3FF] opacity-10 blur-3xl"></div>
    </div>

    

    <form action="" method="post" class="w-1/3 flex flex-col gap-10  border border-[#38373E] rounded-2xl p-10 backdrop-blur-lg">
        <!-- logo -->
        <div class="self-center"><img src="assets/logo.svg" alt="" class="w-32"></div>
        <div>
            <p class="text-3xl font-semibold mb-2">Change Password</p>
            <p class="text-md">Your password must be  at least 8 characters and should include a combination of numbers and letter</p>

        </div>
        <div>
            <div class="flex flex-col gap-6">
                <div class="relative font-sans w-full">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                            name="new_password"
                            type="password"
                            minlength="8"
                            maxlength="32"
                            required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                            New password
                        </label>
                </div>
                    

                <div class="relative font-sans w-full">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                            name="confirm_new_password"
                            type="password"
                            minlength="8"
                            maxlength="32"
                            required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                            Confirm new password
                        </label>
                </div>
            </div>
            <span class=" text-base text-red-500"><?= $pass_error;?></span>
            <span class=" text-base text-red-500"><?= $past_password_error;?></span>
        </div>


           
          
        <div class="w-1/2 z-10 self-center">
            <input type="submit" value="Change Password" name="change_password" class="w-full bg-[#62F3FF] tracking-wider py-3 rounded-full text-black font-semibold text-lg hover:cursor-pointer" >
        </div>
    </form>
</body>
</html>