<?php
    session_start();
    require "database.php";

    // Functions 
    function pathTo($destination) {
        echo "<script>window.location.href = '$destination.php'</script>";
    }


    // Check if 'status' key is set in the session, if not, set it to 'invalid'
    if (!isset($_SESSION['status']) || $_SESSION['status'] == 'invalid'){
        //Set Default Invalid 
        $_SESSION['status'] = 'invalid';  
        
        
    }

    // check if status is valid and direct to home page
    if ($_SESSION['status'] == 'valid' && $_SESSION['role'] == "employee") {
        pathTo('dashboard');
    }

      // check if status is valid and direct to home page
      if ($_SESSION['status'] == 'valid' && $_SESSION['role'] == "admin") {
        pathTo('user_employee');
    }
    // error message
    $error_message = "";
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $login_query = "SELECT * FROM employee WHERE email = '$email' AND password = '$password' AND verified = 'yes'";
        $result = $conn->query($login_query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {


                $_SESSION['status'] = 'valid';
                $_SESSION['id'] = $row['id'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['position'] = $row['position'];
                $_SESSION['role'] = $row['role'];

                if($row['role'] == "admin"){
                    header("Location: user_employee.php");
                }else{
                    header("Location: dashboard.php");
                }
            }
        }else{
            $error_message = "Wrong email or password";
            $_SESSION['status'] = 'invalid';
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
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>
<body class=" h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist">
    <div>
        <img src="assets/r-logo.svg" alt="" class="fixed -top-1/4 left-1/2 transform -translate-x-1/2" >
        <div class="border-2 h-[840px] w-[840px] fixed -top-1/4 left-1/2 transform -translate-x-1/2 rounded-full  bg-[#62F3FF] opacity-5 blur-3xl"></div>
    </div>
    <!-- logo with name -->
    <div><img src="assets/logo.svg" alt="" class="absolute top-10 left-1/2 transform -translate-x-1/2 w-40" id="logo"></div>
    

    <form id="form" method="post" class="w-1/3 flex flex-col gap-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  border border-[#38373E] rounded-2xl p-10 backdrop-blur-lg">
        <!-- logo -->
        <div>
            <p class="text-4xl font-semibold mb-2">Log in</p>
            <p>Dont have an account? <span class="text-[#62F3FF] hover:underline"><a href="register.php">Register</a></span></p>

        </div>

            <div class="flex flex-col gap-6">
                <span class="text-sm text-red-500"><?=$error_message?></span>
                <div class="relative font-sans w-full">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        name="email"
                        type="email"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        Email
                    </label>
                </div>
                

                <div class="relative font-sans w-full">
                    <input class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]"
                        name="password"
                        type="password"
                        required>
                    <label class="absolute left-4 text-[#757575] pointer-events-none transform translate-y-2 transition duration-150 peer-focus:-translate-y-6 peer-focus:scale-90 peer-focus:px-1 peer-focus:left-1 peer-valid:-translate-y-6 peer-valid:scale-90 peer-valid:px-1 peer-valid:left-2 peer-focus:text-[#62F3FF]">
                        Password
                    </label>
                </div>
            </div>

           
        <div class="w-full flex justify-betweem" id="form-btns">
            <div class="w-4/5" id="forgot-password">
                <a href="recovery.php"  class="hover:underline text-[#999999]">Forgot password?</a>
            </div>
             
            <div class="w-1/5 z-10">
                <input id="login-btn" type="submit" value="Log in" name="login" class="w-full bg-[#62F3FF]  py-3 rounded-full text-black font-semibold text-lg hover:cursor-pointer" >
            </div>
        </div>
    </form>
</body>

<style>
     @media only screen and (max-width: 430px) {
        #logo{
            width: 30%;
        }
     
        #form{
            width: 100%;
            border: none;
        }
        #form-btns{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #login-btn{
            width: fit-content;
            font-size: 15px;
            padding-block: 5px;
            padding-inline: 20px;
        }

        #forgot-password{
            width: fit-content;
            font-size: 15px;
        }
    }
</style>
</html>