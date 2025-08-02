<?php
session_start();
require_once 'auth.php';
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: admin_users.php");
exit;
