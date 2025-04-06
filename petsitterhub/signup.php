<?php include 'includes/minimal_header.php'; ?>

<section class="auth-form">
  <div class="container">
    <h2>Create Your Account</h2>
    <form action="process_signup.php" method="POST" enctype="multipart/form-data">
      
      <label for="role">I am a:</label>
      <select name="role" id="role" name="role" required>
        <option value="owner">Pet Owner</option>
        <option value="sitter">Pet Sitter</option>
      </select>

      <label for="name">Full Name:</label>
      <input type="text" name="name" required>

      <label for="email">Email:</label>
      <input type="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" name="confirm_password" required>

      <!-- Sitters-only Fields -->
      <div id="sitter-fields" style="display: none;">
        <label for="bio">Bio:</label><br>
        <textarea name="bio" rows="4" placeholder="Tell us about yourself..."></textarea><br><br>

        <label for="location">Location:</label>
        <input type="text" name="location" placeholder="e.g., New York, NY">
      </div>

      <!-- Profile image shown to both, but label changes -->
      <div id="profile-pic-label">
        <label for="profile_image">Profile Picture:</label>
      </div>
      <input type="file" name="profile_image" accept="image/*">

      <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </div>
</section>

<script>
  const roleSelect = document.getElementById('role');
  const sitterFields = document.getElementById('sitter-fields');
  const profilePicLabel = document.getElementById('profile-pic-label');

  function toggleSitterFields() {
    if (roleSelect.value === 'sitter') {
      sitterFields.style.display = 'block';
      profilePicLabel.querySelector('label').textContent = "Profile Picture (for sitter):";
    } else {
      sitterFields.style.display = 'none';
      profilePicLabel.querySelector('label').textContent = "Profile Picture (optional):";
    }
  }

  roleSelect.addEventListener('change', toggleSitterFields);
  window.addEventListener('DOMContentLoaded', toggleSitterFields);
</script>
