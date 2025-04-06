<?php
include 'includes/session_check.php';
include 'config.php';

if ($_SESSION['user_role'] !== 'sitter') {
  echo "<p>Access denied. Only sitters can view available requests.</p>";
  exit;
}

include 'includes/header.php';

// FIXED: Include location from users table
$sql = "SELECT r.*, u.name AS owner_name, u.location AS owner_location
        FROM pet_care_requests r 
        JOIN users u ON r.owner_id = u.id 
        WHERE r.sitter_id IS NULL AND r.status = 'Pending'";

$result = $conn->query($sql);
?>

<section class="container">
  <h2 class="page-heading">Available Requests</h2>
  <?php if (isset($_GET['success'])): ?>
  <div class="success-message">Request successfully accepted!</div>
  <?php endif; ?>

  <?php if ($result->num_rows > 0): ?>
    <div class="request-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="request-card">
          <div class="request-details">
            <h3><?= htmlspecialchars($row['pet_name']) ?>
              <span class="badge"><?= htmlspecialchars($row['service_type']) ?></span>
            </h3>
            <p><strong>Type:</strong> <?= htmlspecialchars($row['pet_type']) ?></p>
            <p><strong>From:</strong> <?= date("F j, Y", strtotime($row['start_date'])) ?></p>
            <p><strong>To:</strong> <?= date("F j, Y", strtotime($row['end_date'])) ?></p>
            <?php if (!empty($row['additional_notes'])): ?>
              <p><strong>Notes:</strong> <?= nl2br(htmlspecialchars($row['additional_notes'])) ?></p>
            <?php endif; ?>
            <p>
              <strong>Owner:</strong>
              <?= htmlspecialchars($row['owner_name']) ?>
              <?php if (!empty($row['owner_location'])): ?>
                (<?= htmlspecialchars($row['owner_location']) ?>)
              <?php endif; ?>
            </p>
          </div>
          <div class="request-actions">
            <a href="accept_request.php?id=<?= $row['id'] ?>" class="btn-accept">Accept</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>No available requests at the moment.</p>
  <?php endif; ?>
</section>

