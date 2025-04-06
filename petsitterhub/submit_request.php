<?php
include 'includes/session_check.php';
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $owner_id = $_SESSION['user_id'];
  $pet_name = $_POST['pet_name'];
  $pet_type = $_POST['pet_type'];
  $service_type = $_POST['service_type'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $notes = $_POST['notes'];

  if ($start_date > $end_date) {
    echo "Start date cannot be after end date.";
    exit;
  }

  // 1. Insert pet into pets table
  $insert_pet = $conn->prepare("INSERT INTO pets (owner_id, pet_name, pet_type) VALUES (?, ?, ?)");
  $insert_pet->bind_param("iss", $owner_id, $pet_name, $pet_type);
  if (!$insert_pet->execute()) {
    echo "Error inserting pet: " . $insert_pet->error;
    exit;
  }
  $pet_id = $insert_pet->insert_id;
  $insert_pet->close();

  // 2. Insert into pet_care_requests
  $stmt = $conn->prepare("INSERT INTO pet_care_requests (owner_id, pet_id, pet_name, pet_type, service_type, start_date, end_date, additional_notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
  $stmt->bind_param("iissssss", $owner_id, $pet_id, $pet_name, $pet_type, $service_type, $start_date, $end_date, $notes);

  if ($stmt->execute()) {
    header("Location: dashboard.php?msg=Request+submitted+successfully");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
?>
