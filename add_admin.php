<?php
include('includes/db.php');

// Thêm người dùng admin (chạy đoạn này một lần để thêm admin vào CSDL)
$username = 'admin';
$password = password_hash('ie103', PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->close();

echo "Admin user added successfully.";
?>
