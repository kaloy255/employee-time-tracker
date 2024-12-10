<?php

require "session.php";
require "database.php";


if(isset($_POST['delete'])){
    
    $employee_id = (int)$_POST['deleted_id'];

    $query_delete_employee = "DELETE FROM employee WHERE id = $employee_id";
    if ($conn->query($query_delete_employee) === TRUE) {

    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeisBlue | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="fonts.CSS">
    <link rel="icon" href="assets/fav-icon.svg" type="image/x-icon">
</head>


<body class=" min-h-screen bg-gradient-to-br from-[#29282F] to-[#09080F] text-white urbanist flex flex-col gap-20">

    <nav class=" flex justify-between px-20 py-3 border-b border-[#38373E]">
        <!-- logo  -->
        <img src="assets/logo.svg" alt="" class="w-32">
        <div class="flex gap-5">
            <!-- notification icon -->
            <img src="assets/notif-icon.svg" alt="">

            <div class="relative inline-block text-left">
                <!-- Profile Button -->
                <div onclick="toggleDropdown()"
                    class="inline-flex w-full justify-center rounded-md bg-[#29282F] px-4 py-3 text-xs font-medium  shadow-sm hover:cursor-pointer  hover:bg-[#33323C]">
                    <div class="flex items-center gap-2">
                        <img src="assets/default-prof.jpg" alt="" class="w-8 h-8 rounded-full">
                        <div>
                            <p><?=strtoupper($_SESSION['fullname'])?></p>
                            <p class="text-[#999999]"><?=ucwords($_SESSION['position'])?></p>
                        </div>
                    </div>
                    <div class="self-center ml-2 rounded-full hover:bg-[#999999]">
                        <img src="assets/prof-option.svg" alt="">
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu"
                    class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-[#29282F] shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="" class="block px-4 py-2 text-sm hover:bg-[#33323C]" role="menuitem">Settings</a>
                        <a href="logout.php" class="block px-4 py-2 text-sm hover:bg-[#33323C]"
                            role="menuitem">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex  flex-col items-center ">
        <div class="flex items-center gap-5 text-lg ">
            <a href="user_employee.php" class="relative inline-flex items-center border-none bg-none cursor-pointer group">
                <span class="relative text-white uppercase text-sm font-semibold tracking-widest ">
                    User Employee
                    <hr class="bg-[#62F3FF] border-[#62F3FF] border-1 w-full h-[2px]">
                </span>
            </a>

            <hr class="bg-[#38373E] border-[#38373E] rotate-90 w-7 h-[1.5px]">

            <a href="employee_history.php" class="relative inline-flex items-center border-none bg-none cursor-pointer group">
                <span class="relative text-white uppercase text-sm font-semibold tracking-widest ">
                    Employee History
                    <span
                        class="absolute left-0 bottom-0 w-full h-[2px] bg-[#62F3FF] scale-x-0 origin-bottom-right transition-transform duration-300 group-hover:scale-x-100 group-hover:origin-bottom-left">
                    </span>
                </span>
            </a>
        </div>

        <div class=" w-[70%]">
            <div>
                <p class="uppercase text-2xl font-bold text-left">Employees</p>

                <div class="flex justify-between mt-5">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" id="search" placeholder="Type to search..." onkeyup="fetchData()"  class="w-[250px] px-11 py-2 rounded-lg text-md bg-[#29282F]  transition-all duration-200 ease-in-out outline-none opacity-80 focus:opacity-100 focus:w-[400px] hover:w-[400px]" >
                        <svg fill="#ffffff" width="20px" height="20px" viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute top-1/2 left-4 transform -translate-y-1/2">
                            <path
                                d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </div>
                                    
                        
                    <!-- Sort Button for Employee Name -->
                    <button id="sort_button" class="flex items-center gap-2 py-2 px-3 bg-[#62F3FF] rounded-lg text-black font-semibold">
                        Filter <img id="sort_order"src="assets/filter-icon.svg">
                    </button>
                </div>
            </div>
        </div>

        <div class="w-[70%] mt-5">
            <!-- Scrollable rows -->
            <div class="overflow-y-auto h-[500px] custom-scroll relative">
                 <!-- Results Table -->
                <table id="results_table" class="w-full">
                    <thead class="bg-[#29282F] text-left sticky top-0">
                        <tr>
                            <th class="py-2 pl-2 border-r border-[#38373E]">Full name</th>
                            <th class="py-2 pl-2 border-r border-[#38373E]">Email</th>
                            <th class="py-2 pl-2 border-r border-[#38373E]">Age</th>
                            <th class="py-2 pl-2 border-r border-[#38373E]">Full Address</th>
                            <th class="py-2 pl-2 border-r border-[#38373E]">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">No data to display.</td>
                        </tr>
                    </tbody>
                </table>

                <script>
                    const searchInput = document.getElementById("search");
                    const sortButton = document.getElementById("sort_button");
                    const resultsTable = document.getElementById("results_table").getElementsByTagName("tbody")[0];
                    let sortOrder = "asc"; // Default sort order

                    // Fetch and display data
                    function fetchData() {
                        const searchQuery = searchInput.value;

                        const xhr = new XMLHttpRequest();
                        xhr.open("GET", `user_employee_data.php?search=${encodeURIComponent(searchQuery)}&sort_order=${sortOrder}`, true);
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                const results = JSON.parse(xhr.responseText);
                                displayResults(results);
                            }
                        };
                        xhr.send();
                    }

                    // Display results in the table
                    function displayResults(results) {
                        resultsTable.innerHTML = ""; // Clear previous results

                        if (results.length > 0) {
                            results.forEach(row => {
                                const tr = document.createElement("tr");
                                tr.innerHTML = `
                                    <td class="flex items-center gap-2 pl-2 py-3 border-y border-l border-[#29282F]">
                                        <img src="assets/default-prof.jpg" alt="" class="h-10 w-10 rounded-full">
                                        <div class="flex flex-col leading-none"> 
                                            <p class="text-md">${row.fullname}</p>
                                            <p class="text-[#999999] text-sm">${row.position}</p>
                                        </div>
                                    </td>
                                    <td class='pl-2 py-2 border-y border-[#29282F]'>${row.email}</td>
                                    <td class='pl-2 py-2 border-y border-[#29282F]'>${row.age}</td>
                                    <td class='pl-2 py-2 border-y border-[#29282F]'>${row.street_address+" "+row.street_address+" "+row.street_address+" "+row.street_address+" "+row.street_address}</td>
                                    <td class='pl-2 py-2 border-y border-r border-[#29282F]'>
                                        <form action="" method="post">
                                            <input type="hidden" name="deleted_id" value="${row.id}">
                                            <button type="submit" name="delete" onclick="confirmAction(event)" class="text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                `;
                                resultsTable.appendChild(tr);
                            });
                        } else {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `<td colspan="5">No results found.</td>`;
                            resultsTable.appendChild(tr);
                        }
                    }

                    // Sort button functionality
                    sortButton.addEventListener("click", () => {
                        sortOrder = sortOrder === "asc" ? "desc" : "asc";
                        document.getElementById("sort_order").textContent = sortOrder === "asc" ? "⬇️" : "⬆️";
                        fetchData(); // Refetch the data with updated sort order
                    });

                    // Initial fetch of data
                    fetchData(); // Call the fetchData function on page load to show the initial results
                </script>
            </div>
        </div>
    </main>
</body>
<style>
    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar {

        width: 15px;
        /* Width of the scrollbar */
        height: 10px;
        /* Height for horizontal scrollbar */
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #1e1e24;
        /* Scrollbar track background */
        border-radius: 4px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: #52525b;
        /* Scrollbar thumb color */
        border-radius: 4px;
        border: 2px solid #1e1e24;
        /* Adds padding effect */
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #7f7f8d;
        /* Hover effect */
    }
</style>
<script>
    // Function to show confirmation pop-up
    function confirmAction(event) {
        const userConfirmed = confirm("Are you sure you want to delete this user?");
        if (!userConfirmed) {
            event.preventDefault(); // Cancel button click if user chooses "Cancel"
        }
    }
</script>

<script src="script.js"></script>

</html>