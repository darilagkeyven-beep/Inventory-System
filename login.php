<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($password === $user['password']) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Update user status and login timestamp
            $update = $conn->prepare("UPDATE users SET is_online = TRUE, last_login = NOW(), last_active = NOW() WHERE id = ?");
            $update->bind_param("i", $user['id']);
            $update->execute();

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: index.html");
            } else {
                header("Location: Inventory_2.html");
            }
            exit();
        }
    }
    echo "Invalid username or password. <a href='login.html'>Try again</a>";
}
?>