<?php
   
    require "session.php";
    require "database.php";

    $employee_id = $_SESSION['id'];
    date_default_timezone_set('Asia/Manila');

    $date = date('Y-m-d');
    $sql = "SELECT * FROM time_entries WHERE date = '$date' AND time_ended != '' AND employee_id = $employee_id";
    $result = $conn->query($sql);

    $total_seconds = 0;  // To store total time difference in seconds
    $regular_hours= 0;
    $overtime_hours= 0;
    // array container for time entries
    $time_entries = [];
    // error for time entries
    $time_entries_error = "";
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
                $time1 = new DateTime($row['time_started']); // Start time
                $time2 = new DateTime($row['time_ended']);  // End time
                $datetime = $row['created_at'] ;
                $interval = $time1->diff($time2);
                // Add the current interval's seconds to the total
                $total_seconds += $interval->h * 3600 + $interval->i * 60 + $interval->s;
                
                  // Store date and time stopped in the array
                $time_entries[] = [
                    'date' => $row['date'],
                    'time_stopped' => $interval->format('%H:%I:%S')
                ];
               
        }

        $query_chk_regular_hour = "SELECT regular_hour, over_time FROM daily_session WHERE employee_id = $employee_id";
        $employee_result = mysqli_query($conn, $query_chk_regular_hour);
        $row = mysqli_fetch_assoc($employee_result);

        $regular_hours = $row['regular_hour'] * 3600;

        if ($total_seconds > $regular_hours) {
            $overtime_hours = $total_seconds - $regular_hours;
            $total_seconds =  $total_seconds - $overtime_hours;
        } else {
            $overtime_hours = $overtime_hours;
        }
        
    } else {
        $time_entries_error  = "No records";
        
    }
    

    $queryUpdate = "UPDATE daily_session 
                        SET time_consumed = $total_seconds,
                            over_time = $overtime_hours
                        WHERE employee_id = $employee_id AND date = '$date'";
    mysqli_query($conn, $queryUpdate);

  
?>