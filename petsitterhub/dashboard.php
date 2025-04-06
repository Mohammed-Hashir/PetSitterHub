<?php
include 'includes/session_check.php';
include 'includes/header.php';

$role = $_SESSION['user_role'];
$name = $_SESSION['user_name'];
?>





    <?php if ($role === 'owner'): ?>
      <div class="dashboard-wrapper">
        <div class="dashboard-box">
          <h2>Welcome 👋</h2>
          <div class="dashboard-buttons">
            <a href="create_request.php" class="btn">📄 Create a Pet Care Request</a>
            <a href="view_sitters.php" class="btn">📍 View Nearby Pet Sitters</a>
            <a href="manage_bookings.php"" class="btn">📅 Manage My Bookings</a>
            <!--<a href="#" class="btn">💬 Chat with Sitters</a>
            <a href="#" class="btn">⭐ My Reviews</a> -->
          </div>
        </div>
      </div>



    <?php elseif ($role === 'sitter'): ?>
      <div class="dashboard-wrapper">
        <div class="dashboard-box">
          <h2>Welcome 👋</h2>
          <div class="dashboard-buttons">
      <a href="available_requests.php" class="btn">📥 View Available Requests</a>
      <a href="sitter_bookings.php" class="btn">📅 Manage My Bookings</a>
      <!-- <a href="earnings.php" class="btn">💰 Earnings & Payouts</a>-->
      <!--<a href="chat.php" class="btn">💬 Live Chat</a>
      <a href="ratings.php" class="btn">⭐ My Ratings</a> -->
      </div>
        </div>
      </div>
    <?php endif; ?>

  
