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
        $query_start_daily_session = "INSERT INTO daily_session (employee_id, date) VALUES ($employee_id, '$date')";
        
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
    <title>Employee Time Tracking</title>
    <style>
        #timer {
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

   
    <a href="logout.php"> logout</a>
    <div class="timer" id="timer">00:00:00</div>

    <form id="timeInForm" action="" method="POST">
        <input type="submit" id="timeInButton" value="Clock In" name="start">
    </form>

    <form id="timeOutForm" action="" method="POST" style="display: none;">
        <input type="submit" id="timeOutButton" value="Clock Out" name="stop">
    </form>

    <div>
        <h1>Total Hours Worked</h1>
    </div>

    <?php
    foreach($time_entries as  $time){
        echo "Time Stopped at:  ".$time."<br>";
    }
    ?>
<!-- 
    need to use loopings to get the past dily session of employee -->
    <div>
        <p><?=$readableDate;?></p>
        <p>Total time consumed: <?=$hours?>Hours <?=$minutes?>minutes <?=$seconds;?>seconds</p>
        <p>Overtime: <?=$ot_hours?>Hours <?=$ot_minutes?>minutes <?=$ot_seconds;?>seconds</p>
    </div>
</body>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


<script>
    // Timer variables
    let timer;
    let startTime;
    
    // Get timer display element
    const timerDisplay = document.getElementById('timer');

    // Format time (hh:mm:ss)
    function formatTime(seconds) {
        let hrs = Math.floor(seconds / 3600);
        let mins = Math.floor((seconds % 3600) / 60);
        let secs = Math.floor(seconds % 60);
        return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }

    // Start the timer when employee clicks "Clock In"
    document.getElementById('timeInForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent form from submitting immediately
        startTime = Date.now();

        // Start the timer
        timer = setInterval(function() {
            let elapsed = Math.floor((Date.now() - startTime) / 1000);
            timerDisplay.textContent = formatTime(elapsed);
        }, 1000);

        // Hide Clock In button and show Clock Out button
        document.getElementById('timeInButton').style.display = 'none';
        document.getElementById('timeOutForm').style.display = 'block';

        // Optionally send the form data to the server for "Clock In"
        fetch('', { method: 'POST', body: new URLSearchParams({ 'start': '1' }) })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });

    // Stop the timer when employee clicks "Clock Out"
    document.getElementById('timeOutForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent form from submitting immediately

        // Stop the timer
        clearInterval(timer);

        // Optionally send the form data to the server for "Clock Out"
        fetch('', { method: 'POST', body: new URLSearchParams({ 'stop': '1' }) })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));

        // Reset UI
        document.getElementById('timeOutForm').style.display = 'none';
        document.getElementById('timeInButton').style.display = 'block';
        timerDisplay.textContent = "00:00:00";
    });

</script>


</html>
