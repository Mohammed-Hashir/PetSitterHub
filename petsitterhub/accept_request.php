<?php
include 'includes/session_check.php';
include 'config.php';

if ($_SESSION['user_role'] !== 'sitter') {
  echo "<p>Access denied. Only sitters can accept requests.</p>";
  exit;
}

$request_id = $_GET['id'] ?? null;
$sitter_id = $_SESSION['user_id'];

if ($request_id && is_numeric($request_id)) {
  // Update the request to assign it to the sitter
  $stmt = $conn->prepare("UPDATE pet_care_requests SET sitter_id = ?, status = 'Confirmed' WHERE id = ? AND sitter_id IS NULL");
  $stmt->bind_param("ii", $sitter_id, $request_id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    // Redirect with success message
    header("Location: available_requests.php?success=1");
    exit;
  } else {
    $error = "Request could not be accepted. It may have been accepted by someone else.";
  }
} else {
  $error = "Invalid request ID.";
}

include 'includes/header.php';
?>

<section class="container">
  <h2 class="page-heading">Accept Request</h2>
  <?php if (isset($error)): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <p><a href="available_requests.php">Go back to available requests</a></p>
  <?php endif; ?>
</section>


