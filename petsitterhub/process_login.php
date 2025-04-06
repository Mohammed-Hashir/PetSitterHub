<?php
session_start();
include 'config.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT id, name, password, role FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];  // 👈 This sets it on login
    $_SESSION['user_role'] = $user['role'];

    
    header("Location: dashboard.php");
    exit();
  } else {
    die("Incorrect password.");
  }
} else {
  die("No account found with that email.");
}
?>
