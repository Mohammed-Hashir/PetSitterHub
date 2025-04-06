<?php
include 'includes/session_check.php';
include 'config.php';

if ($_SESSION['user_role'] !== 'sitter') {
  echo "<p>Access denied.</p>";
  exit;
}

include 'includes/header.php';

$sitter_id = $_SESSION['user_id'];
$sql = "SELECT r.*, u.name AS owner_name 
        FROM pet_care_requests r 
        JOIN users u ON r.owner_id = u.id 
        WHERE r.sitter_id = ? 
        ORDER BY r.start_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sitter_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="container">
  <h2 class="page-heading">Manage Bookings</h2>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
       Booking marked as completed.
    </div>
  <?php elseif (isset($_GET['cancelled'])): ?>
    <div class="alert alert-warning">
       Booking has been cancelled.
    </div>
  <?php endif; ?>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="request-card">
        <div class="request-details">
          <h3><?= htmlspecialchars($row['pet_name']) ?> (<?= htmlspecialchars($row['pet_type']) ?>)</h3>
          <p><strong>Service:</strong> <?= htmlspecialchars($row['service_type']) ?></p>
          <p><strong>From:</strong> <?= $row['start_date'] ?> to <?= $row['end_date'] ?></p>
          <p><strong>Owner:</strong> <?= htmlspecialchars($row['owner_name']) ?></p>
          <p><strong>Status:</strong> 
            <?php
              $status = htmlspecialchars($row['status']);
              if ($status === 'Confirmed') {
                echo "<span style='color:green;'>$status</span>";
              } elseif ($status === 'Completed') {
                echo "<span style='color:blue;'>$status</span>";
              } elseif ($status === 'Cancelled') {
                echo "<span style='color:red;'>$status</span>";
              } else {
                echo $status;
              }
            ?>
          </p>
          <?php if (!empty($row['additional_notes'])): ?>
            <p><strong>Notes:</strong> <?= htmlspecialchars($row['additional_notes']) ?></p>
          <?php endif; ?>
        </div>

        <?php if ($row['status'] === 'Confirmed'): ?>
          <div class="request-actions">
            <a href="complete_booking.php?request_id=<?= $row['id'] ?>" class="btn-complete"> Mark as Completed</a>

            <a href="cancel_booking.php?request_id=<?= $row['id'] ?>" class="btn-cancel"> Cancel</a>
            </div>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No bookings found for you at the moment.</p>
  <?php endif; ?>
</section>

