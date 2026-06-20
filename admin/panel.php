<?php
session_start();

include "../backend.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: redirect.php");
    exit;
}

$error = "";

// delete
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];

    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $me = $stmt->fetch();

    if ($id != $me['id']) {
        $db->prepare("DELETE FROM score_history WHERE user_id = ?")->execute([$id]);
        $db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
        header("Location: panel.php");
        exit;
        // 如果是自已的error
    } else {
        $error = "You cannot delete yourself!";
    }
}

// check全部用户
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
    <!-- Font Awesome Icon CDN start -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/fontawesome.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/sharp-solid.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/sharp-regular.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/sharp-light.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/duotone.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/solid.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/regular.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/light.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/brands.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/sharp-duotone-solid.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/chisel-regular.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/etch-solid.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/graphite-thin.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/jelly-regular.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/notdog-solid.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/slab-regular.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/thumbprint-light.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/utility-semibold.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/whiteboard-semibold.css" />
    <!-- Font Awesome CDN END -->
</head>

<body>
    <div class="panel-header">
        <h1 class="panel-title">ADMIN PANEL</h1>

        <div class="header-second">
            <a href="add-user.php" class="panel-button">Add Users</a>
            <a href="add-skin.php" class="panel-button">Add Skins</a>
        </div>
    </div>

    <table class="user-table">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Score</th>
            <th>Delete</th>
        </tr>

        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['role'] == 1 ? "ADMIN" : "USER"; ?></td>
                <td><?php echo $user['score'] ?></td>
                <td>
                    <!-- ask user要不要delete -->
                    <form method="post" onsubmit="return confirm('Delete this user?');">
                        <input type="hidden" name="delete_id" value="<?php echo $user['id'] ?>">
                        <button type="submit" name="delete" class="del-btn">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php if ($error != "") { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <a href="../index.php" class="panel-back">← Back to Game</a>
    </div>
</body>

</html>