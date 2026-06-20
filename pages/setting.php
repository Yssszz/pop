<?php
session_start();
$banned = json_decode(file_get_contents("../banned.json"), true);
$error = "";
$isBad = false;

if (!isset($_SESSION['username'])) {
    header("Location: ../pop/admin/redirect.php");
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['rename'])) {
    include("../backend.php");
    $new = strtolower(trim($_POST['new_username']));
    $old = $username;

    if ($new == "") {
        $error = "You Need To Type Something..";
    } elseif (strlen($new) < 5) {
        $error = "You Need At Least 5 Character For Username..";
    } elseif ($new == $old) {
        $error = "Its Same..";
    } else {
        foreach ($banned as $word) {
            if (str_contains($new, $word)) {
                $isBad = true;
                break;
            }
        }

        if ($isBad) {
            $error = "Bad Word Detected..";
        } else {
            $stmt = $db->prepare("SELECT * FROM users WHERE `username` = ?");
            $stmt->execute([$new]);
            $user = $stmt->fetch();
            if ($user) {
                $error = "Username Already Taken...";
            } else {
                $stmt = $db->prepare("UPDATE users SET username = ? WHERE username = ?");
                $stmt->execute([$new, $old]);

                $_SESSION['username'] = $new;
                header("Location: setting.php");
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="setting.css">
    <title>Settings</title>
</head>

<body>
    <div class="auth">
        <div class="card">
            <h1 class="title">SETTINGS</h1>

            <span id="user-hi">CURRENT USERNAME: <?php echo $_SESSION['username']; ?></span>

            <?php if ($error != "") { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>

            <form method="post" class="form">
                <input type="text" name="new_username" placeholder="New Username" class="input">
                <button type="submit" name="rename" class="btn">Change Name</button>
            </form>

            <a href="../sign/logout.php" class="btn" id="logout">LOGOUT</a>

            <a href="../index.php" class="link">← Back to Game</a>
        </div>
    </div>
</body>

</html>