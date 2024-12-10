<?php
require 'database.php';      

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get parameters from AJAX request
$searchQuery = $_GET['search'] ?? '';
$sortOrder = $_GET['sort_order'] ?? 'asc';
// Build the query dynamically
$queryStr = "SELECT * FROM employee WHERE `role` = 'employee' AND 1";

$params = [];

// Add search filter
if (!empty($searchQuery)) {
    $queryStr .= " AND fullname LIKE :searchQuery";
    $params['searchQuery'] = '%' . $searchQuery . '%';
}

// Add sorting by employee_name
$queryStr .= " ORDER BY fullname $sortOrder";

$query = $pdo->prepare($queryStr);
$query->execute($params);
$data = $query->fetchAll(PDO::FETCH_ASSOC);


// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
