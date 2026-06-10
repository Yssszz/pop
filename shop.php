<?php
session_start();
include "backend.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


$username = $_SESSION['username'];
$stmt = $db->prepare("SELECT score FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$myScore = $user['score'];

$stmt = $db->query("SELECT * FROM skins ORDER BY unlock_score ASC");
$skins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="shop.css">
    <title>Shop</title>
</head>

<body>
    <div class="shop-wrap">
        <h1 class="shop-title">SHOP</h1>
        <p class="shop-score">Your Score: <?php echo $myScore; ?></p>

        <div class="shop-grid">
            <?php foreach ($skins as $skin) { ?>
                <div class="skin-card">
                    <img src="<?php echo $skin['image']; ?>" class="skin-img">
                    <p class="skin-name"><?php echo $skin['name']; ?></p>

                    <?php if ($myScore >= $skin['unlock_score']) { ?>
                        <button class="skin-btn" onclick="selectSkin(<?php echo $skin['id']; ?>)">Use</button>
                    <?php } else { ?>
                        <span class="skin-locked"><?php echo $skin['unlock_score']; ?> pts</span>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <a href="index.php" class="shop-back">← Back to Game</a>
    </div>
    <script>
        function selectSkin(skinId) {
            fetch("select_skin.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "skin_id=" + skinId
            });
            alert("Skin Selected");
        }
    </script>
</body>

</html>