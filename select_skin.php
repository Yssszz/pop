<?php
session_start();
include "backend.php";

$username = $_SESSION['username'];
$skin_id = $_POST['skin_id'];

$stmt = $db->prepare("UPDATE users SET current_skin = ? WHERE username = ?");
$stmt->execute([$skin_id, $username]);
