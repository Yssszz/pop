<?php
session_start();
include "backend.php";

if (!isset($_SESSION['username']) || $_POST['skin_id']) {
    exit;
}

$username = $_SESSION['username'];
$skin_id = $_POST['skin_id'];

$stmt = $db->prepare("UPDATE users SET current_skin = ? WHERE username = ?");
$stmt->execute([$skin_id, $username]);
