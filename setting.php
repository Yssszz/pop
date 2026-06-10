<?php
session_start();
include "backend.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['rename'])) {
    $new = $_POST['new_username'];
    $old = $_SESSION['username'];

    if ($new == "") {
        echo "Need to fill something.";
    } else {
        $stmt = $db->prepare("UPDATE users SET username = ? WHERE username = ?");
        $stmt->execute([$new, $old]);

        $_SESSION['username'] = $new;
        header("Location: setting.php");
        exit;
    }
}

if (isset($_POST['change_pass'])) {
    $newpass = $_POST['new_password'];
    $old = $_SESSION['username'];

    if ($newpass == "") {
        echo ("Need to fill something.");
    } else {
        $hash = password_hash($newpass, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE users SET `password` = ? WHERE `username` = ?");
        $stmt->execute([$hash, $old]);

        header("Location: setting.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="sign.css">
    <title>Settings</title>
</head>

<body>
    <div class="auth">
        <div class="card">
            <h1 class="title">SETTINGS</h1>

            <form method="post" class="form">
                <input type="text" name="new_username" placeholder="New Username" class="a-input">
                <button type="submit" name="rename" class="a-btn">Change Name</button>
            </form>

            <form method="post" class="form">
                <input type="text" name="new_password" placeholder="New Password" class="a-input">
                <button type="submit" name="change_pass" class="a-btn">Change Name</button>
            </form>

            <a href="logout.php" class="a-btn" style="text-align:center; text-decoration:none;">Logout</a>

            <a href="index.php" class="a-link">← Back to Game</a>
        </div>
    </div>
</body>

</html>