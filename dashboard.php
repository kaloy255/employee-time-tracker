<?php
require "database.php"; 
require "fetch.php"; 

date_default_timezone_set('Asia/Manila');



$employee_id = $_SESSION['id'];
// Handle Clock In
if (isset($_POST['start'])) {
    $date = date('Y-m-d');
    $time_in = date("Y-m-d H:i:s");
    
    // Query for inserting time entries
    $query = "INSERT INTO time_entries (date, time_started, employee_id) VALUES ('$date', '$time_in', $employee_id)";
    
    if (mysqli_query($conn, $query)) {
        // Successfully inserted
    } else {
        echo "Error inserting into time_entries: " . mysqli_error($conn);
    }

    // Check if there is already a daily session for today
    $check = "SELECT * FROM daily_session WHERE employee_id = '$employee_id' AND date = '$date'";
    $result = mysqli_query($conn, $check);

    if (!$result) {
        echo "Error checking daily session: " . mysqli_error($conn);
    } elseif (mysqli_num_rows($result) == 0) {
        // Insert the time in entry
        $query_start_daily_session = "INSERT INTO daily_session (employee_id, date, regular_hour) VALUES ($employee_id, '$date', DEFAULT)";
        
        if (mysqli_query($conn, $query_start_daily_session)) {
            // Successfully inserted
        } else {
            echo "Error inserting into daily_session: " . mysqli_error($conn);
        }
    }
}

// Handle Clock Out
if (isset($_POST['stop'])) {
    $date = date('Y-m-d');
    $time_out = date("Y-m-d H:i:s");

    // Update the time_entries table for the current day
    $queryUpdate = "UPDATE time_entries SET time_ended = '$time_out' WHERE employee_id = $employee_id AND date = '$date' AND time_ended = ''";
    
    if (mysqli_query($conn, $queryUpdate)) {
        // Successfully updated
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
<body class=" h-screen bg-gradient-to-br from-[#29282F] to-[#09080F] text-white urbanist flex flex-col ">

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

<main class="self-center w-full flex justify-around flex-col items-center h-full">
    <div id="border-timer" class="flex flex-col items-center gap-5 border border-[#38373E] rounded-lg w-1/3 py-10">
        <!-- digital timer -->
        <div class="timer text-8xl" id="timer">00:00:00</div>

        <div>
            <!-- start button -->
            <form id="timeInForm" action="" method="POST">
               
                <button type="submit" id="timeInButton" name="start"  class="bg-gradient-to-r from-[#24D9E8] to-[#9C0777] rounded-full py-3 px-10 text-xl flex items-center gap-2"><img src="assets/start-icon.svg" alt=""> <span>START</span></button>
                
            </form>
            <!-- stop button -->
            <form id="timeOutForm" action="" method="POST" style="display: none;" >
                    <button type="submit" id="timeOutButton"  name="stop" class="bg-[#29282F] rounded-full py-3 px-10 text-xl flex items-center gap-2"> <img src="assets/stop-icon.svg" alt=""> <span>STOP</span></button>
            </form>
        </div>
    </div>

    <div class="w-1/2">
        <div class="flex items-center justify-between mb-2">
            <p class="text-2xl">Activity Log</p>
            <p class="px-5 py-2 bg-[#29282F] rounded-lg text-sm">Total Hours Consumed: <span><?php echo $hours,"H " . $minutes."mins"?></span></p>
        </div>

        <div class="flex justify-center flex-col gap-5">
            <div class=" h-[225px] overflow-hidden flex flex-col gap-5">
                <?php foreach (array_reverse($time_entries) as $entries): ?>
                    <div class="w-full border border-[#38373E] px-5 py-2 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <img src="assets/default-prof.jpg" alt="" class="w-8 w-8 rounded-full">
                                <div>
                                    <p class="text-sm"><?=$_SESSION['fullname']?></p>
                                    <p class="text-sm text-[#999999]"><?=strtok($_SESSION['email'], "@")?></p>
                                </div>
                            </div>
                            <div>
                                <p><?=$entries['time_stopped']?></p>
                                <p class="text-xs text-[#999999]">Stopped</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <a href="history.php" class="py-2 px-5 bg-[#62F3FF] rounded-full text-black w-1/5 text-center self-center font-semibold">Review Past Entries</a>
        </div>
    </div>

</main>
</body>
<script src="script.js"></script>
</html>
