<?php
include 'includes/session_check.php';
$role = $_SESSION['user_role'];
$name = $_SESSION['user_name'];

include 'includes/header.php';
include 'config.php';

$result = $conn->query("SELECT name, bio, location, profile_image FROM users WHERE role = 'sitter'");
?>

<section class="container">
  <h2>Nearby Pet Sitters</h2>
  <div class="sitter-cards">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="sitter-card">
        <?php
          $imgPath = (!empty($row['profile_image']) && file_exists("uploads/" . $row['profile_image']))
                    ? "uploads/" . htmlspecialchars($row['profile_image'])
                    : "assets/images/default.png";
        ?>
        <img src="<?php echo $imgPath; ?>" alt="Profile Picture">

        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
        <p><?php echo htmlspecialchars($row['bio']); ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</section>

