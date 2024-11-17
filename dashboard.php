<?php

require "calculate_time_gap.php"; 
// Start button
if (isset($_POST['start'])) {
    // insert the value of timein in session
    $_SESSION['time_in'] = date("Y-m-d H:i:s");
}


// Stop button
if (isset($_POST['stop'])) {
    // get the current date
    $date = date('Y-m-d');
    // get the started time in session value
    $time_in = $_SESSION['time_in'];
    // ended time
    $time_out = date("Y-m-d H:i:s");
    $employee_id = (int)$_SESSION['id'];

    // insert the started and ended time in database
    $query_insert_entries = "INSERT INTO time_entries (employee_id,time_started, time_ended, date) VALUES ($employee_id,'$time_in', '$time_out', '$date')";
    
    if (mysqli_query($conn, $query_insert_entries)) {
        $check_session = "SELECT * FROM daily_session WHERE employee_id = $employee_id AND date = '$date'";
        $result = mysqli_query($conn, $check_session);
        if (mysqli_num_rows($result) > 0) {
            
        }else{
            $query_start_daily_session = "INSERT INTO daily_session (employee_id, date, regular_hour) VALUES ($employee_id, '$date', DEFAULT)";
            mysqli_query($conn, $query_start_daily_session);
        }
    } else {
        echo "Error updating time_entries: " . mysqli_error($conn);
    }
}

   


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeisBlue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">

</head>
<body class=" min-h-screen bg-gradient-to-br from-[#29282F] to-[#09080F] text-white urbanist flex flex-col gap-20">

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

<main class="self-center w-full flex flex-col items-center gap-40 h-full">
    <div id="border-timer" class="flex flex-col items-center gap-5 border border-[#38373E] rounded-lg w-1/3 py-10">
        <!-- digital timer -->
        <div class="timer text-8xl" id="timer">00:00:00</div>

        <div>
            <!-- start button -->
            <form id="timeInForm"  method="POST">
                <button type="submit" id="timeInButton" name="start"  class="bg-gradient-to-r from-[#24D9E8] to-[#9C0777] rounded-full py-3 px-10 text-xl flex items-center gap-2"><img src="assets/start-icon.svg" alt=""> <span>START</span></button>
            </form>
            <!-- stop button -->
            <form id="timeOutForm"  method="POST" style="display: none;" >
                <button type="submit" id="timeOutButton" name="stop" class="bg-[#29282F] rounded-full py-3 px-10 text-xl flex items-center gap-2"> <img src="assets/stop-icon.svg" alt=""> <span>STOP</span></button>
            </form>
        </div>
    </div>

    <div class="w-1/2">
        <div  class=" h-[250px] overflow-hidden">
            <div class="flex items-center justify-between">
                <p class="text-2xl font-semibold">Activity Log</p>
                <p class="px-3 py-2 bg-[#29282F] rounded-md text-[#999999] text-sm"> Total Hours Consumed: 
                    <span class="text-white">
                        <?php 
                            foreach ($current_sessions as $session):
                                echo gmdate("H:i:s", $session['time_consumed']);
                            endforeach; 
                        ?>
                    </span>
                </p>
            </div>

            <?php foreach (array_reverse($current_time_entry) as $entrie): ?>
                <div class="border border-[#38373E] px-5 py-3 rounded-md mt-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="assets/default-prof.jpg" alt="" class="w-8 h-8 rounded-md">
                        <div class="text-sm leading-none">
                            <p><?=$_SESSION['fullname']?></p>
                            <p class="text-[#999999] text-xs"><?=$_SESSION['fullname']?></p>
                        </div>
                    </div>

                    <div class="leading-none text-sm">
                        <p><?=$entrie['time_stopped']?></p>
                        <p class="text-xs text-[#999999]">Stopped</p>
                    </div>
                </div>
        <?php endforeach; ?>
       </div>

       <div class="text-center mt-5"><a href="history.php" class="px-5 py-2 bg-[#62F3FF] rounded-full text-black font-semibold">Review Past Entries</a></div>
    </div>
    
</main>
</body>
<script src="script.js"></script>
</html>
