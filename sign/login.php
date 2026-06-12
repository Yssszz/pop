<?php
session_start();
$error = "";

if (isset($_POST['submit'])) {
    include("../backend.php");

    $username = strtolower(trim($_POST['username']));  
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        $error = "Please Fill in Username and Password";
    } else {
        $stmt = $db->prepare("SELECT * FROM users WHERE `username` = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Username Or Password Error..";
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
    <title>Login</title>
</head>

<body>
    <div class="overlay">
        <div class="card">
            <h1 class="register">LO<span class="h1">GIN</span></h1>

            <?php if ($error != "") { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>

            <form method="post" class="form">
                <input type="text" name="username" placeholder="Username" class="input">
                <input type="password" name="password" placeholder="Password" class="input">
                <button type="submit" name="submit" class="btn">LOGIN</button>
                <a href="signup.php" class="link">Don't have an account? Sign up</a>
            </form>
        </div>
    </div>
</body>

</html>