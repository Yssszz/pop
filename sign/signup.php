<?php
$banned = json_decode(file_get_contents("../banned.json"), true);
$error = "";
$hasBad = false;

if (isset($_POST['submit'])) {
    include("../backend.php");

    $username = strtolower(trim($_POST['username']));
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        $error = "You Need To Fill Something...";
    } elseif (strlen($username) < 5) {
        $error = "You Need At Least 5 Character For Username..";
    } elseif (strlen($password) < 6) {
        $error = "You Need At Least 6 Character For Password..";
    } else {
        foreach ($banned as $word) {
            if (str_contains($username, $word)) {
                $hasBad = true;
                break;
            }
        }

        if ($hasBad) {
            $error = "Bad Words Detected..";
        } else {
            $stmt = $db->prepare("SELECT * FROM users WHERE `username` = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                $error = "Someone Already Named This";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (`username`, `password`) VALUES (?, ?)");
                $stmt->execute([$username, $hash]);

                header("Location: login.php");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>Register</title>
</head>

<body>
    <div class="overlay">
        <div class="card">
            <h1 class="register"><span class="h1">RE</span>GISTER</h1>

            <?php if ($error != "") { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>

            <form method="post" class="form">
                <input type="text" name="username" placeholder="Username" class="input">
                <input type="password" name="password" placeholder="Password" class="input">
                <button type="submit" name="submit" class="btn">REGISTER</button>
                <a href="login.php" class="link">
                    Already Have An account? Login
                </a>
            </form>
        </div>
    </div>
</body>

</html>