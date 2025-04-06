<?php
include('config.php');
include('includes/session_check.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'sitter') {
    echo "Access denied.";
    exit;
}

if (!isset($_GET['request_id']) || !is_numeric($_GET['request_id'])) {
    echo "Invalid request ID.";
    exit;
}

$request_id = intval($_GET['request_id']);
$sitter_id = $_SESSION['user_id'];

// 1. Fetch request details
$query = "SELECT pet_id, start_date, end_date, status FROM pet_care_requests WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Booking not found.";
    exit;
}

$row = $result->fetch_assoc();
$pet_id = $row['pet_id'];
$start_date = $row['start_date'];
$end_date = $row['end_date'];
$status = $row['status'];

if (!$pet_id || !$start_date || !$end_date) {
    echo "Incomplete booking data.";
    exit;
}

if ($status === 'Completed') {
    header("Location: sitter_bookings.php?already=completed");
    exit;
}

// 2. Calculate days and amount
$start = new DateTime($start_date);
$end = new DateTime($end_date);
$days = $start->diff($end)->days + 1;
$rate_per_day = 500;
$amount = $days * $rate_per_day;

// 3. Update booking status
$updateQuery = "UPDATE pet_care_requests SET status = 'Completed' WHERE id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $request_id);
$stmt->execute();

// 4. Insert into sitter_earnings
$insertQuery = "INSERT INTO sitter_earnings (sitter_id, pet_id, amount, paid) VALUES (?, ?, ?, 0)";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("iid", $sitter_id, $pet_id, $amount);

if ($stmt->execute()) {
    header("Location: sitter_bookings.php?success=1");
    exit;
} else {
    echo "Failed to insert earnings: " . $stmt->error;
}
?>
