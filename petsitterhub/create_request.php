<?php
include 'includes/session_check.php';
include 'includes/header.php';

if ($_SESSION['user_role'] !== 'owner') {
  echo "<p>Access denied. Only pet owners can create requests.</p>";
  include 'includes/footer.php';
  exit;
}
?>

<div class="auth-form">
  <div class="container">
    <h2>Create a Pet Care Request</h2>
    <form action="submit_request.php" method="POST">
      <label for="pet_name">Pet Name:</label>
      <input type="text" name="pet_name" id="pet_name" required>

      <label for="pet_type">Pet Type:</label>
      <input type="text" name="pet_type" id="pet_type" required>

      <label for="service_type">Service Type:</label>
      <select name="service_type" id="service_type" required>
        <option value="">-- Select Service --</option>
        <option value="Sitting">Sitting</option>
        <option value="Walking">Walking</option>
        <option value="Grooming">Grooming</option>
        <option value="Training">Training</option>
      </select>

      <label for="start_date">Start Date:</label>
      <input type="date" name="start_date" id="start_date" required>

      <label for="end_date">End Date:</label>
      <input type="date" name="end_date" id="end_date" required>

      <label for="notes">Additional Notes:</label>
      <textarea name="notes" id="notes" rows="4" style="resize: vertical; padding: 0.6rem; border: 1px solid #ccc; border-radius: 5px;"></textarea>

      <button type="submit">Submit Request</button>
    </form>
  </div>
</div>


