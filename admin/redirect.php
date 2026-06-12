<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="redirect.css">
    <title>Access Denied</title>
</head>

<body>
    <div class="deny-wrap">
        <div class="deny-card">
            <?php if (isset($_SESSION['username'])) { ?>
                <h1 class="deny-code">403</h1>
            <?php } else { ?>
                <h1 class="deny-code">67</h1>
            <?php } ?>

            <?php if (isset($_SESSION['username'])) { ?>
                <p class="deny-msg">ACCESS DENIED</p>
            <?php } else { ?>
                <p class="deny-msg">You Need To Login...</p>
            <?php } ?>

            <?php if (isset($_SESSION['username'])) { ?>
                <span class="deny-sub">You don't have permission to view this page.</span>
            <?php } else { ?>
                <span class="deny-sub">Please log in to continue.</span>
            <?php } ?>

            <?php if (isset($_SESSION['username'])) { ?>
                <a href="../index.php" class="deny-btn">← Back to Game</a>
            <?php } else { ?>
                <a href="../sign/login.php" class="deny-btn">LOGIN</a>
            <?php } ?>

        </div>
    </div>
</body>

</html>