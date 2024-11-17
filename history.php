<?php
    require "database.php"; 
    require "session.php"; 
    date_default_timezone_set('Asia/Manila');


    $current_date = date("Y-m-d");

    $employee_id = $_SESSION['id'];

    $total_seconds = 0;
   
    $time_entries = []; //time entries array container

    // calculate the time gap in database of TIME ENTRIES
    $query_time_entries = "SELECT * FROM time_entries WHERE employee_id = $employee_id";
    $result = mysqli_query($conn, $query_time_entries);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // date every data in time entries
            $entries_date = $row['date'];

            $time_started = new DateTime($row['time_started']);
            $time_ended = new DateTime($row['time_ended']);
            $interval = $time_started->diff($time_ended);
            // Convert each time gap to seconds
            $seconds = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
            $total_seconds += $seconds; // Add to the total seconds
           
            $timegap = $interval->format("%H:%I:%S");  // format the time gap to 00:00:00 every data in database time entries
          
            // store the time gap in array
            $time_entries[] = [
                'date' => $entries_date,
                'time_stopped' => $timegap
            ];


        }
    } 
    else {
    }


    // whole session
    $sessions = [];   // session container array
    // store the data of dailysession in array
    $query_daily_session = "SELECT * FROM daily_session WHERE employee_id = $employee_id";
    $query_daily_session_results = mysqli_query($conn, $query_daily_session);
    if (mysqli_num_rows($query_daily_session_results) > 0){
        while($row = $query_daily_session_results->fetch_assoc()) {
            
            $sessions[] = [
                'date' => $row['date'],
                'time_consumed' => ($row['time_consumed']+$row['over_time'])
            ];
        }
    } 
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

    <main class="flex flex-col overflow-auto relative py-20">
        <div class="ml-10 top-[7rem] fixed">
            <a href="dashboard.php" class="flex items-center text-[#999999] gap-1 text-xl"><img src="assets/back-icon.svg" alt=""> Back</a>
        </div>

        <div class="w-1/2 self-center flex flex-col gap-20">
            <?php foreach (array_reverse($sessions) as $session): ?>
                <div>
                    <div class="flex items-center justify-between bg-[#29282F] py-2 px-3 text-[#999999] text-sm">
                        <p>
                            <?php if ($session['date'] == $current_date): 
                                echo "Today";
                            else: 
                                echo date("F j, Y", strtotime($session['date']));
                            endif; ?>
                        </p>
                        <p>
                            <?=gmdate("H:i:s", $session['time_consumed']);?>
                        </p>
                    </div>
                    <?php foreach (array_reverse($time_entries) as $entries): ?>
                        <?php if ($entries['date'] == $session['date']): ?>
                            <div class="border border-[#38373E] p-5 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <img src="assets/default-prof.jpg" alt="" class="w-8 h-8 rounded-md">
                                    <div class="text-sm leading-none">
                                        <p><?=$_SESSION['fullname']?></p>
                                        <p class="text-[#999999] text-xs"><?=$_SESSION['fullname']?></p>
                                    </div>
                                </div>

                                <div class="leading-none text-sm ">
                                    <p>
                                        <?= $entries['time_stopped']?>
                                    </p>
                                    <p class="text-[#999999] text-xs">Stopped</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach;?>
                    
                </div>
            <?php endforeach;?>


        </div>
    </main>

    
</body>
<script src="script.js"></script>
</html>