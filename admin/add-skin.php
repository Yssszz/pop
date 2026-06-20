<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: redirect.php");
    exit;
}

include("../backend.php");

$error = "";
$success = "";

if (isset($_POST['submit'])) {

    $stmt = $db->prepare("SELECT * FROM skins WHERE `name` = ?");
    $stmt->execute([$_POST['name']]);
    $name = $stmt->fetch();

    if ($name) {
        $error = "Skin name already exists!";
    } elseif ($_POST['unlock_score'] === '') {
        $error = "Score cannot be empty!";
    } elseif (!is_numeric($_POST['unlock_score'])) {
        $error = "Score must be a number!";
    } elseif ($_POST['unlock_score'] < 0) {
        $error = "Score cannot be negative!";
    } elseif (trim($_POST['image']) === '') {
        $error = "Image path is required!";
    }

    if ($error === "") {
        $stmt = $db->prepare("INSERT INTO skins (`name`, `unlock_score`, `image`, `image_open`) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['unlock_score'],
            $_POST['image'],
            $_POST['image_open']
        ]);
        $success = "Done Added Skin!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Skins</title>
    <link rel="stylesheet" href="add-skin.css">
</head>

<body>
    <div class="panel-wrap">
        <div class="panel-header">
            <h1 class="panel-title">ADD SKIN</h1>
        </div>

        <?php if ($error !== "") { ?>
            <p class="error"><?= $error ?></p>
        <?php } ?>

        <?php if ($success !== "") { ?>
            <p class="done"><?= $success ?></p>
        <?php } ?>

        <form action="add-skin.php" method="POST" class="skin-form">
            <input type="text" name="name" placeholder="Skin Name" required>
            <input type="number" name="unlock_score" placeholder="Unlock Score" required>
            <input type="text" name="image" placeholder="Image (closed) like: images/cat2.png" required>
            <input type="text" name="image_open" placeholder="Image (open) like: images/cat2_open.png">
            <button type="submit" name="submit" class="panel-button">Add Skin</button>
        </form>

        <a href="panel.php" class="panel-back">← Back to Admin Panel</a>
    </div>
</body>

</html>