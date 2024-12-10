<?php
require "database.php";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if we are fetching dates
if (isset($_GET['action']) && $_GET['action'] == 'get_dates') {
    // Fetch distinct dates from the daily_session table
    $query = $pdo->prepare("SELECT DISTINCT DATE(date) AS date FROM daily_session ORDER BY date DESC");
    $query->execute();
    $dates = $query->fetchAll(PDO::FETCH_ASSOC);

    // Return the dates as JSON
    header('Content-Type: application/json');
    echo json_encode($dates);
    exit;
}

// Get parameters from AJAX request
$searchQuery = $_GET['search'] ?? '';
$selectedDate = $_GET['filter_date'] ?? '';
$sortOrder = $_GET['sort_order'] ?? 'asc';

// Build query dynamically
$queryStr = "SELECT SEC_TO_TIME(ds.time_consumed) AS time_consumed, SEC_TO_TIME(ds.over_time) AS over_time, ds.date, e.fullname, e.position
             FROM daily_session ds 
             JOIN employee e ON ds.employee_id = e.id 
             WHERE 1=1";
$params = [];

// Add search filter
if (!empty($searchQuery)) {
    $queryStr .= " AND e.fullname LIKE :searchQuery";
    $params['searchQuery'] = '%' . $searchQuery . '%';
}

// Add date filter
if (!empty($selectedDate)) {
    $queryStr .= " AND DATE(ds.date) = :selectedDate";
    $params['selectedDate'] = $selectedDate;
}

// Add sorting by employee_name
$queryStr .= " ORDER BY e.fullname $sortOrder";

$query = $pdo->prepare($queryStr);
$query->execute($params);
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>