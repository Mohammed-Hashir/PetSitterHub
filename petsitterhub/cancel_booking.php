<?php
include('config.php');
include('includes/session_check.php');

// Check if the user is a sitter
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'sitter') {
    echo "Access denied.";
    exit;
}

// Check if request_id is provided
if (!isset($_GET['request_id']) || !is_numeric($_GET['request_id'])) {
    echo "Invalid request.";
    exit;
}

$request_id = intval($_GET['request_id']);
$sitter_id = $_SESSION['user_id'];

// Optional: verify that the sitter owns this booking
$check = $conn->prepare("SELECT id FROM pet_care_requests WHERE id = ? AND sitter_id = ?");
$check->bind_param("ii", $request_id, $sitter_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    echo "Booking not found or access denied.";
    exit;
}

// Update status to Cancelled
$update = $conn->prepare("UPDATE pet_care_requests SET status = 'Cancelled' WHERE id = ?");
$update->bind_param("i", $request_id);
$update->execute();

header("Location: sitter_bookings.php?cancelled=1");
exit;
?>
