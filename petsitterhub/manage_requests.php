<?php
include 'includes/session_check.php';
include 'includes/header.php';
include 'config.php';

$owner_id = $_SESSION['user_id'];
$sql = "SELECT * FROM pet_care_requests WHERE owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
  <h2>My Bookings</h2>
  <table>
    <tr>
      <th>Pet</th>
      <th>Service</th>
      <th>Dates</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['pet_name']) ?> (<?= htmlspecialchars($row['pet_type']) ?>)</td>
      <td><?= htmlspecialchars($row['service_type']) ?></td>
      <td><?= $row['start_date'] ?> to <?= $row['end_date'] ?></td>
      <td><?= $row['status'] ?></td>
      <td>
        <?php if ($row['status'] != 'Cancelled'): ?>
          <form action="cancel_request.php" method="POST" style="display:inline;">
            <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
            <button type="submit" onclick="return confirm('Are you sure you want to cancel this request?')">Cancel</button>
          </form>
        <?php else: ?>
          N/A
        <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

