<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Sort Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Live Search and Sorting by Employee Name</h1>

    <!-- Search Bar -->
    <label for="search">Search Employee Name:</label>
    <input type="text" id="search" placeholder="Type to search..." onkeyup="fetchData()">

    <!-- Sort Button -->
    <button id="sort_button">
        Sort by Employee Name <span id="sort_order">⬇️</span>
    </button>

    <!-- Results Table -->
    <table id="results_table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Date</th>
                <th>Time Consumed</th>
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
                        <td>${row.fullname}</td>
                        <td>${row.position}</td>
                        <td>${row.age}</td>
                        <td>${row.street_address}</td>
                        <td>${row.country}</td>
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
</body>
</html>
