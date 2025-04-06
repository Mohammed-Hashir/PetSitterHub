<?php include 'includes/minimal_header.php'; ?>
<section class="auth-form">
  <div class="container">
    <h2>Login to Your Account</h2>
    <form action="process_login.php" method="POST">
      <label for="email">Email:</label>
      <input type="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Create one</a>.</p>
  </div>
</section>


