<?php
    require "fetch.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>
<body class=" h-screen bg-gradient-to-br from-[#29282F] to-[#09080F] text-white urbanist flex flex-col">
    <nav class=" flex justify-between px-20 py-3 border-b border-[#38373E]">
    <!-- logo  -->
        <img src="assets/logo.svg" alt="" class="w-32">
        <div class="flex gap-5">
            <!-- notification icon -->
            <img src="assets/notif-icon.svg" alt="">

            <div class="relative inline-block text-left">
                <!-- Profile Button -->
                <div onclick="toggleDropdown()" class="inline-flex w-full justify-center rounded-md bg-[#29282F] px-4 py-3 text-xs font-medium  shadow-sm hover:cursor-pointer  hover:bg-[#33323C]">
                    <div class="flex items-center gap-2">
                        <img src="assets/default-prof.jpg" alt="" class="w-8 h-8 rounded-full">
                        <div>
                            <p><?=$_SESSION['fullname']?></p>
                            <p class="text-[#999999]"><?=strtok($_SESSION['email'], "@")?></p>
                        </div>
                    </div>
                    <div class="self-center ml-2 rounded-full hover:bg-[#999999]">
                        <img src="assets/prof-option.svg" alt="">
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-[#29282F] shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="" class="block px-4 py-2 text-sm hover:bg-[#33323C]" role="menuitem">Settings</a>
                        <a href="logout.php" class="block px-4 py-2 text-sm hover:bg-[#33323C]" role="menuitem">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex flex-col h-full">
        <a href="dashboard.php" class="text-[#999999] text-2xl font-thin flex items-center gap-2 "><img src="assets/back-icon.svg" alt="">Back</a>

        <div class="w-1/2 self-center ">
            <div>
                <?php foreach (array_reverse($sessions) as $session): ?>
                    <div class="flex items-center justify-between bg-[#29282F] px-5 py-2">
                        <?php if ($session['date'] == $readableDate): ?>
                            <p>Today</p>
                        <?php else: ?>
                            <p><?=$session['date']?></p>
                        <?php endif; ?>
                        <p>
                            <?=$session['time']['hours'] . " Hours ". $session['time']['minutes']." Minutes"?>
                            </p>
                    </div>
                    <div class="py-2 border border-[#38373E]">
                        <div class="flex items-center gap-2">
                            <img src="assets/default-prof.jpg" alt="" class="w-8 w-8 rounded-full">
                            <div>
                                <p class="text-sm"><?=$_SESSION['fullname']?></p>
                                <p class="text-sm text-[#999999]"><?=strtok($_SESSION['email'], "@")?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
                
            </div>

        </div>

       
        

    </main>
    
</body>
<script src="script.js"></script>
</html>