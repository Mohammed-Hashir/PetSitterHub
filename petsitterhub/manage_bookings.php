<?php
include 'includes/session_check.php';
include 'config.php';

if ($_SESSION['user_role'] !== 'owner') {
  echo "<p>Access denied. Only pet owners can manage bookings.</p>";
  exit;
}

include 'includes/header.php';

$user_id = $_SESSION['user_id'];

// Fetch all bookings for this owner
$sql = "SELECT r.*, u.name AS sitter_name 
        FROM pet_care_requests r 
        LEFT JOIN users u ON r.sitter_id = u.id 
        WHERE r.owner_id = ? 
        ORDER BY r.start_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="container">
  <h2 class="page-heading">My Bookings</h2>

  <?php if (isset($_GET['cancelled']) && $_GET['cancelled'] == '1'): ?>
    <div class="alert alert-warning">Booking request cancelled successfully.</div>
  <?php endif; ?>

  <?php if ($result->num_rows > 0): ?>
    <div class="booking-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="booking-card">
          <div class="booking-details">
            <p><strong><?= htmlspecialchars($row['pet_name']) ?> (<?= htmlspecialchars($row['pet_type']) ?>)</strong></p>
            <p>Service: <?= htmlspecialchars($row['service_type']) ?></p>
            <p>From: <?= $row['start_date'] ?> To: <?= $row['end_date'] ?></p>
            <p>Status: <strong><?= htmlspecialchars($row['status']) ?></strong></p>
            <?php if (!empty($row['sitter_name'])): ?>
              <p>Sitter: <?= htmlspecialchars($row['sitter_name']) ?></p>
            <?php endif; ?>
            <?php if (!empty($row['additional_notes'])): ?>
              <p>Notes: <?= nl2br(htmlspecialchars($row['additional_notes'])) ?></p>
            <?php endif; ?>
          </div>
          <div class="booking-actions">
            <?php if ($row['status'] === 'Pending'): ?>
              <a href="edit_request.php?request_id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
              <a href="cancel_request.php?request_id=<?= $row['id'] ?>" class="btn-cancel" onclick="return confirm('Cancel this request?')">Cancel</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>You haven't made any booking requests yet.</p>
  <?php endif; ?>
</section>

