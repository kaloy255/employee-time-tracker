<?php 
    require "recovery-code.php"; 
    
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
    if ($_SESSION['status'] == 'valid') {
        pathTo('dashboard');
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Recovery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>
<body  class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist flex justify-center items-center">

    <div >
        <img src="assets/r-logo.svg" alt="" class="fixed top-[12rem] left-1/2  transform -translate-x-1/2 translate-x-20 w-[15%]" id="bg-logo">
        <div class="border-2 h-[18rem] fixed top-[12rem] left-1/2  transform -translate-x-1/2 translate-x-20 w-[15%]  rounded-full  bg-[#62F3FF] opacity-15 blur-3xl" id="bg-lightlogo"></div>
    </div>


    <div class=" border border-[#38373E] rounded-2xl p-10 backdrop-blur-md rounded max-w-md w-1/2 " id="form">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Account Recovery</h2> 
        <form id="recoveryForm" action="recovery-code.php" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]" required>
                <span class="text-sm text-red-500"> <?php echo isset($_SESSION['recovery-message']) ? $_SESSION['recovery-message'] : ''; ?></span>
            </div>
            <div class="flex justify-center">
                <button 
                type="submit" 
                name="send_email_btn"
                class=" bg-[#62F3FF]  text-black font-bold py-2 px-4 rounded"
                id="send-btn"
                >
                    Send Recovery Email
                </button>
            </div>
        </form>
    </div>
</body>
<style>
    @media only screen and (max-width: 430px) {
        #form{
            width: 100%;
            border: none;
        }

        #form form input{
            font-size: 12px;
        }

        #bg-logo{
            width: 100%;
        }
        #bg-lightlogo{
            width: 100%;
        }
        #send-btn{
            font-size: 15px;
        }


    }
</style>
</html>
