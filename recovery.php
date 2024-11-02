<?php 
    require "recovery-code.php"; 

    
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
</head>
<body  class="h-screen bg-gradient-to-bl from-[#29282F] to-[#09080F] relative overflow-hidden text-white urbanist flex justify-center items-center">

    <div >
        <img src="assets/r-logo.svg" alt="" class="fixed right-[38rem] top-[12rem]  w-[15%]">
        <div class="border-2 h-[18rem] w-[15%] fixed right-[38rem] top-[12rem]  rounded-full  bg-[#62F3FF] opacity-15 blur-3xl"></div>
    </div>


    <div class=" border border-[#38373E] rounded-2xl p-10 backdrop-blur-md rounded max-w-md w-1/2 ">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Account Recovery</h2> 
        <form id="recoveryForm" action="recovery-code.php" method="POST" class="space-y-6">
            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="w-full peer border border-[#38373E] rounded-xl bg-transparent p-2 text-base transition duration-150 focus:outline-none focus:ring-0 focus:border-[#62F3FF]" required>
                <span class="text-sm text-red-500"><?=$_SESSION['recovery-message'];?></span>
            </div>
            <div class="flex justify-center">
                <button 
                type="submit" 
                name="send_email_btn"
                class=" bg-[#62F3FF]  text-black font-bold py-2 px-4 rounded ">
                    Send Recovery Email
                </button>
            </div>
        </form>
    </div>
</body>
</html>
