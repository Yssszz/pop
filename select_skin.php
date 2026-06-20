<?php
session_start();
include "backend.php";

if (!isset($_SESSION['username']) || !isset($_POST['skin_id'])) {
    exit;
}
// u know i kno
$username = $_SESSION['username'];
// from js
$skin_id = $_POST['skin_id'];

// check user id
$stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
$me = $stmt->fetch();

// record change skin history
$stmt = $db->prepare("INSERT INTO skins_history (`user_id`, `skin_id`) VALUES (?,?)");
$stmt->execute([$me['id'], $skin_id]);

// change skin
$stmt = $db->prepare("UPDATE users SET current_skin = ? WHERE username = ?");
$stmt->execute([$skin_id, $username]);
