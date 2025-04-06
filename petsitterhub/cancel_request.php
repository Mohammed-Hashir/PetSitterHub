<?php
include('config.php');
include('includes/session_check.php');

if (!isset($_GET['request_id']) || !is_numeric($_GET['request_id'])) {
    echo "Invalid request.";
    exit;
}

$request_id = intval($_GET['request_id']);
$owner_id = $_SESSION['user_id'];

// Optional: check if the logged-in user owns the request
$checkQuery = "SELECT id FROM pet_care_requests WHERE id = ? AND owner_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $request_id, $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "You are not authorized to cancel this request.";
    exit;
}

// Update the status to 'Cancelled'
$cancelQuery = "UPDATE pet_care_requests SET status = 'Cancelled' WHERE id = ?";
$stmt = $conn->prepare($cancelQuery);
$stmt->bind_param("i", $request_id);
$stmt->execute();

// Redirect back with success message
header("Location: manage_bookings.php?cancelled=1");
exit;
?>
