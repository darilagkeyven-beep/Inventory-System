<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: Inventory_2_12.html");
    } else {
        header("Location: Inventory_2_12.html");
    }
    exit();
}

// Redirect to login or load main interface
header("Location: Inventory_2_12.html");
exit();
?>