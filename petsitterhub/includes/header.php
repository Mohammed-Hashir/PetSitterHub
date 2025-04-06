

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetSitterHub</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="container nav">
        <a href="index.php"><img src="assets/images/logo.png" alt="PetSitterHub Logo" class="logo"></a>
        <nav>
          <a href="logout.php" class="btn btn-logout">Log Out</a>
        </nav>
      </div>
    <?php else: ?>
      <div class="container nav">
        <a href="index.php"><img src="assets/images/logo.png" alt="PetSitterHub Logo" class="logo"></a>
        <nav>
          <a href="login.php" class="btn">Login</a>
          <a href="signup.php" class="btn btn-primary">Sign Up</a>
        </nav>
      </div>
      <?php endif; ?>
  </header>

  


