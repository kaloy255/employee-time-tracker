<?php
require "calculate_time_gap.php";
require "database.php";
// Fetch total hours worked

$query_daily_session = "SELECT * FROM daily_session WHERE employee_id = $employee_id ORDER BY date";
$daily_result = mysqli_query($conn, $query_daily_session);
$sessions = []; // Array to store each session as an object

if (!$daily_result) {
    echo "Error fetching daily sessions: " . mysqli_error($conn);
} else {
   

    if ($daily_result->num_rows > 0) {
        while ($row = $daily_result->fetch_assoc()) {
            // Calculate hours, minutes, and seconds for time_consumed
            $hours = floor($row["time_consumed"] / 3600);
            $minutes = floor(($row["time_consumed"] % 3600) / 60);
            $seconds = $row["time_consumed"] % 60;

            // Calculate hours, minutes, and seconds for over_time
            $ot_hours = floor($row["over_time"] / 3600);
            $ot_minutes = floor(($row["over_time"] % 3600) / 60);
            $ot_seconds = $row["over_time"] % 60;

            // Create a DateTime object and format it
            $dateTime = new DateTime($row['date']);
            $readableDate = $dateTime->format('F j, Y');

            // Store the data in an object
            $session = [
                'id' => $row['id'],
                'date' => $readableDate,
                'time' => [
                    'hours' => $hours,
                    'minutes' => $minutes,
                    'seconds' => $seconds,
                ],
                'over_time' => [
                    'hours' => $ot_hours,
                    'minutes' => $ot_minutes,
                    'seconds' => $ot_seconds,
                ],
                'fullname' => $_SESSION['fullname'],
                'email' => $_SESSION['email']
            ];

            // Add the session object to the sessions array
            $sessions[] = $session;
        }

        // Output each session data (for testing or usage)
       
    }
}
?>
