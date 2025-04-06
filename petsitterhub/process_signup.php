<?php
session_start();
include 'config.php';

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];
$role     = $_POST['role'];

$bio      = $_POST['bio'] ?? '';
$location = $_POST['location'] ?? '';

// Validate password match
if ($password !== $confirm) {
    die("Passwords do not match.");
}

// Check if email is already registered
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Email already registered.");
}
$stmt->close();

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Handle profile image upload
$profileImageName = null;

if (!empty($_FILES['profile_image']['name'])) {
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));

    if (!in_array($imageFileType, $allowedTypes)) {
        die("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Ensure uploads directory exists
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Generate a unique filename
    $profileImageName = uniqid('img_', true) . '.' . $imageFileType;
    $targetFilePath = $targetDir . $profileImageName;

    if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
        die("Failed to upload profile image.");
    }
}

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role, bio, location, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $hashed, $role, $bio, $location, $profileImageName);

if ($stmt->execute()) {
    $_SESSION['user_id']   = $stmt->insert_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_role'] = $role;
    header("Location: dashboard.php");
    exit;
} else {
    echo "Signup failed. Try again.";
}
?>
