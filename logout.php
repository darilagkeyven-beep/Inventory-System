<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Set user status to offline
    $stmt = $conn->prepare("UPDATE users SET is_online = FALSE, last_active = NOW() WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Unset all session variables and destroy the session
$_SESSION = array();
session_destroy();

// Redirect back to login screen
header("Location: Inventory_2_12.html");
exit();
?>