// settings logout dropdown
function toggleDropdown() {
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.classList.toggle("hidden");
}
window.addEventListener("click", function(e) {
    const dropdown = document.getElementById("dropdownMenu");
    const profileButton = dropdown.previousElementSibling;
    if (!profileButton.contains(e.target) && !dropdown.classList.contains("hidden")) {
      dropdown.classList.add("hidden");
    }
});


    // timer dashboard
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
 
    // Start the timer when employee clicks "Start"
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
 
        // Apply gradient border with radius when Clock In
        const borderTimer = document.getElementById('border-timer');
        borderTimer.style.borderImage = 'linear-gradient(to right, #24D9E8, #9C0777) 1'; // Gradient border
        borderTimer.style.borderRadius = '8px';
    });
 
    // Stop the timer when employee clicks "Stop"
    document.getElementById('timeOutForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent form from submitting immediately
 
        // Stop the timer
        clearInterval(timer);
 
        // Reset UI
        document.getElementById('timeOutForm').style.display = 'none';
        document.getElementById('timeInButton').style.display = 'flex';
        document.getElementById('border-timer').style.borderImage = 'none'; // Remove border-image
        document.getElementById('border-timer').style.borderColor = '#38373E'; // Set border color
        timerDisplay.textContent = "00:00:00";
    });
 