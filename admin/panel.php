<?php
session_start();
include "../backend.php";

// ===== 门卫:挡住非 admin(你写过,我替你放好) =====
if (!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: redirect.php");
    exit;
}

// ===== 查出所有用户 =====
$stmt = $db->query("SELECT id, username, role, score FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="panel.css">
    <title>Admin Panel</title>
</head>

<body>
    <div class="panel-wrap">
        <h1 class="panel-title">ADMIN PANEL</h1>

        <table class="user-table">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Score</th>
            </tr>

            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['username'] ?></td>
                    <td><?php echo $user['role'] == 1 ? "ADMIN" : "USER"; ?></td>
                    <td><?php echo $user['score'] ?></td>
                </tr>
            <?php } ?>
        </table>

        <a href="../index.php" class="panel-back">← Back to Game</a>
    </div>
</body>

</html>