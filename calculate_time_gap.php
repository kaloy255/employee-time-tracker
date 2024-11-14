<?php
    require "database.php"; 
    require "session.php"; 
    date_default_timezone_set('Asia/Manila');


    $current_date = date("Y-m-d");

    $employee_id = $_SESSION['id'];
    
    $current_overtime_hours= 0;
    $current_total_seconds = 0; 
    $current_time_entry = []; //time entries array container

  
    // calculate the time gap in database of TIME ENTRIES
    $current_query_time_entries = "SELECT * FROM time_entries WHERE employee_id = $employee_id  AND date = '$current_date'";
    $current_result = mysqli_query($conn, $current_query_time_entries);

    if (mysqli_num_rows($current_result) > 0) {
        while($row = mysqli_fetch_assoc($current_result)) {
            // date every data in time entries
            $entry_date = $row['date'];

            $time_started = new DateTime($row['time_started']);
            $time_ended = new DateTime($row['time_ended']);
            $interval = $time_started->diff($time_ended);
            // Convert each time gap to seconds
            $seconds = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
            $current_total_seconds += $seconds; // Add to the total seconds
           
            $timegap = $interval->format("%H:%I:%S");  // format the time gap to 00:00:00 every data in database time entries
            // store the time gap in array
            $current_time_entry[] = [
                'date' => $entry_date,
                'time_stopped' => $timegap
            ];


        }
    } 
    else {
    }
  
 
    // update the total time consumed in daily session
    $update_session = "SELECT * FROM daily_session WHERE employee_id = $employee_id AND date = '$current_date'"; 
    $update_session_results = mysqli_query($conn, $update_session);
    if (mysqli_num_rows($update_session_results) > 0) {

        // check the over time
        $query_chk_regular_hour = "SELECT regular_hour, over_time FROM daily_session WHERE employee_id = $employee_id";
        $employee_result = mysqli_query($conn, $query_chk_regular_hour);
        $row = mysqli_fetch_assoc($employee_result);
        // regular hours work convert to seconds
        $regular_hours = $row['regular_hour'] * 3600;
        // check if total time hours is greater than regular hour
        if ($current_total_seconds > $regular_hours) {
            $current_overtime_hours = $current_total_seconds - $regular_hours;
            $current_total_seconds =  $current_total_seconds - $current_overtime_hours;
        } else {
            $current_overtime_hours = $current_overtime_hours;
        }

        // update the daily session of employee
        $queryUpdate = "UPDATE daily_session 
        SET time_consumed = $current_total_seconds, over_time = $current_overtime_hours
        WHERE employee_id = $employee_id AND date = '$current_date'";
        mysqli_query($conn, $queryUpdate);
    }else{
    }

   
    // current session
    $current_sessions = [];   // session container array
    // store the data of dailysession in array
    $query_daily_session = "SELECT * FROM daily_session WHERE employee_id = $employee_id AND date = '$current_date'";
    $query_daily_session_results = mysqli_query($conn, $query_daily_session);
    if (mysqli_num_rows($query_daily_session_results) > 0){
        while($row = $query_daily_session_results->fetch_assoc()) {
            
            $current_sessions[] = [
                'date' => $row['date'],
                'time_consumed' => $row['time_consumed']+$row['over_time']
            ];
        }
    } 

?>