<?php
session_start();
       // Functions 
       function pathTo($destination) {
        echo "<script>window.location.href = '$destination.php'</script>";
    }


    // Check if 'status' key is set in the session, if not, set it to 'invalid'
    if (!isset($_SESSION['status']) || $_SESSION['status'] == 'invalid'){
        //Set Default Invalid 
        $_SESSION['status'] = 'invalid';  
        
        
    }

    // check if status is valid and direct to home page
    if ($_SESSION['status'] == 'valid') {
        pathTo('dashboard');
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
<body class=" bg-gradient-to-br from-[#29282F] to-[#09080F] text-white urbanist ">

    <nav class="flex justify-between items-center py-5 px-[10rem]">
        <img src="assets/logo.svg" alt="" class="w-32">


        <div class="flex justify-around items-center gap-5 font-semibold ">
            <a href="login.php" class="text-lg">Log in</a>
            <a href="register.php" class="bg-[#62F3FF] py-2 px-5 text-black rounded-full  font-semibold hover:bg-[#41D5E0]" >Register</a>
        </div>
    </nav>

    <main class="flex justify-center mt-20 flex-col items-center gap-20">
        <div class="flex flex-col items-center  gap-5 w-1/2 text-center">
            <p class="text-5xl font-bold">The most popular free time tracker for freelancers</p>
            <p>Trusted by millions, this time-tracking software offers a user-friendly timer and an intuitive app. It helps you track work hours across multiple projects, with unlimited users, free of charge — forever.</p>
            <a href="register.php" class="relative inline-flex items-center justify-center px-6 py-2.5 text-black font-semibold text-lg rounded-full bg-gradient-to-r from-[#00d9f5] to-[#00b6d5] hover:bg-[length:200%_auto] animate-pulse focus:outline-none">Start Timer for Free</a>
        </div>

        <img src="assets/dashboard-pic.jpg" alt="" class="w-[60%] rounded-md">
    </main>
</body>


<style>
    /* Change the scroll bar track and thumb colors */
::-webkit-scrollbar {
    width: 15px; /* Width of the scroll bar */
}

/* Track */
::-webkit-scrollbar-track {
    background: #09080F; /* Background color of the scroll bar track */

}

/* Thumb */
::-webkit-scrollbar-thumb {
    background-color: #555; /* Color of the scroll bar thumb */
    
}

/* Hover effect on scroll thumb */
::-webkit-scrollbar-track:hover {
    background-color: #333; /* Color when hovered */
}


@keyframes backgroundIMG {
  100% {
    background-image: linear-gradient(#bf66ff, #6248ff, #00ddeb);
  }
}

.card:nth-child(6):hover {
  background-color: #8c9eff;
}

.card:nth-child(6):hover .discord {
  fill: white;
}

.card:nth-child(7):hover {
  background-color: black;
}

.card:nth-child(7):hover .github {
  fill: white;
}

.card:nth-child(8):hover {
  background-color: #29b6f6;
}

.card:nth-child(8):hover .telegram > path:nth-of-type(1) {
  fill: white;
}

.card:nth-child(8):hover .telegram > path:nth-of-type(2) {
  fill: #29b6f6;
}

.card:nth-child(8):hover .telegram > path:nth-of-type(3) {
  fill: #29b6f6;
}

.card:nth-child(9):hover {
  background-color: rgb(255, 69, 0);
}

.card:nth-child(9) .reddit > g circle {
  fill: rgb(255, 69, 0);
}

.card:nth-child(9) .reddit > g path {
  fill: white;
}

.text {
  position: absolute;
  font-size: 0.7em;
  transition: 0.4s ease-in-out;
  color: black;
  text-align: center;
  font-weight: bold;
  letter-spacing: 0.33em;
  z-index: 3;
}



    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(0, 217, 245, 0.4);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(0, 182, 213, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(0, 182, 213, 0);
      }
    }
    .animate-pulse {
      animation: pulse 1.5s infinite;
    }

    button:hover .actual-text {
        visibility: hidden; /* Hide the actual text on hover */
    }
    button:hover .hover-text {
        width: 100%; /* Expand the hover text to full width on hover */
        filter: drop-shadow(0 0 23px #37FF8B); /* Add a glow effect */
    }

  </style>
</html>