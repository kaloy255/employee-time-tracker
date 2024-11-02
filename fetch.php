<?php
    require "calculate_time_gap.php";
    require "database.php";
    // Fetch total hours worked


    $query_daily_session = "SELECT * FROM daily_session WHERE employee_id = $employee_id ORDER BY date ";
    $daily_result = mysqli_query($conn, $query_daily_session);

    if (!$daily_result) {
        echo "Error fetching daily sessions: " . mysqli_error($conn);
    } else {
        if ($daily_result->num_rows > 0) {
            while ($row = $daily_result->fetch_assoc()) {
                // calculate seconds into human readable
                $hours = floor($row["time_consumed"] / 3600);
                $minutes = floor(($row["time_consumed"] % 3600) / 60);
                $seconds = $row["time_consumed"] % 60;
                $ot_hours = floor($row["over_time"] / 3600);
                $ot_minutes = floor(($row["over_time"] % 3600) / 60);
                $ot_seconds = $row["over_time"] % 60;

                // Create a DateTime object 
                $dateTime = new DateTime($row['date']);
                // Convert to human-readable format (Month Day, Year)
                $readableDate = $dateTime->format('F j, Y');
            }
        } else {
            echo "0 results";
        }
        
    }


?>