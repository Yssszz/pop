<?php
session_start();
include("backend.php");

$username = $_SESSION['username'];

$stmt = $db->prepare("UPDATE users SET score = score + 1 WHERE username = ?");
$stmt->execute([$username]);    


$stmt = $db->prepare("SELECT id, score FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user['score'] % 100 == 0) {
    $db->prepare("INSERT INTO score_history (user_id, score) VALUES (?, ?)")
        ->execute([$user['id'], $user['score']]);
}
