<?php
session_start();

// Set cooldown period in seconds (e.g., 300 seconds = 5 minutes)
$cooldown_period = 180;
$remaining_time = 0;

// Check if the resend code button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resend_code'])) {
    $current_time = time();
    $last_resend_time = $_SESSION['last_resend_time'] ?? 0;

    // Check if the cooldown period has elapsed
    if ($current_time - $last_resend_time >= $cooldown_period) {
        // Update last resend time in the session
        $_SESSION['last_resend_time'] = $current_time;

        // Simulate resend logic here (replace with actual resend function)
        $resend_successful = resendVerificationCode(); // Replace with actual resend function

        if ($resend_successful) {
            echo "<script>alert('Verification code has been resent successfully. Please check your email.');</script>";
        } else {
            echo "<script>alert('Failed to resend verification code. Please try again later.');</script>";
        }
    } else {
        // Calculate remaining time for cooldown
        $remaining_time = $cooldown_period - ($current_time - $last_resend_time);
    }
} else {
    // If page is loaded without a POST request, calculate remaining time based on last resend time
    $current_time = time();
    $last_resend_time = $_SESSION['last_resend_time'] ?? 0;
    if ($current_time - $last_resend_time < $cooldown_period) {
        $remaining_time = $cooldown_period - ($current_time - $last_resend_time);
    }
}

// Placeholder function for actual resend logic
function resendVerificationCode() {
    return true; // Simulate success
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resend Verification Code</title>
    <script>
    // JavaScript Countdown Timer
    let remainingTime = <?php echo $remaining_time; ?>; // Get remaining time from PHP

    function updateTimer() {
        const button = document.getElementById('resendButton');
        const timerDisplay = document.getElementById('timerDisplay');

        if (remainingTime > 0) {
            button.disabled = true;
            button.innerText = `Resend Verification Code (${remainingTime} seconds)`;
            timerDisplay.innerText = `You can resend the code in ${remainingTime} seconds.`;
            remainingTime--;

            // Call updateTimer every second
            setTimeout(updateTimer, 1000);
        } else {
            button.disabled = false;
            button.innerText = "Resend Verification Code";
            timerDisplay.innerText = ""; // Clear timer message
        }
    }

    // Start the countdown if there is remaining time
    window.onload = function() {
        if (remainingTime > 0) {
            updateTimer();
        }
    };
    </script>
</head>
<body>
    <form method="POST" action="">
        <button type="submit" name="resend_code" id="resendButton">Resend Verification Code</button>
        <p id="timerDisplay" style="color: red;"></p> <!-- Timer display area -->
    </form>
</body>
</html>
