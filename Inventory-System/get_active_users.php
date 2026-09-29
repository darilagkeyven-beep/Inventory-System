<?php
header('Content-Type: application/json');
require 'db.php';

// Simulate role checking (In production, replace this with session validation)
$role = isset($_GET['role']) ? $_GET['role'] : 'user';

if ($role !== 'admin') {
    http_response_code(403);
    echo json_encode(["message" => "Access denied: Admins only."]);
    exit();
}

// 1. Query for all currently online users
$onlineResult = $conn->query("SELECT id, username, last_active FROM users WHERE is_online = TRUE");
$onlineUsers = $onlineResult->fetch_all(MYSQLI_ASSOC);

// 2. Query for the single most recently active user overall
$lastActiveResult = $conn->query("SELECT id, username, is_online, last_active FROM users ORDER BY last_active DESC LIMIT 1");
$lastActiveUser = $lastActiveResult->fetch_assoc();

// Output response as JSON
echo json_encode([
    "online_users" => $onlineUsers,
    "last_active_user" => $lastActiveUser
]);
?>