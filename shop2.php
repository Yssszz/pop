<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../pop/admin/redirect.php");
    exit;
}

include("backend.php");
$username = $_SESSION['username'];
$stmt = $db->prepare("SELECT `score`, `current_skin` FROM users WHERE `username` = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// 玩家的score
$myScore = $user['score'];
// 玩家目前的skin
$myCurrentSkin = $user['current_skin'];

$stmt = $db->query("SELECT * FROM skins ORDER BY `unlock_score` ASC");
$skins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="shop2.css">
    <title>SHOP</title>
</head>

<body>
    <div class="wrap">
        <h1 id="title">SHOP</h1>
        <p id="your-score">Your Score: <?php echo $myScore ?></p>

        <div class="grid">
            <?php foreach ($skins as $skin) { ?>
                <div class="card">
                    <img class="skin-img" src="<?php echo $skin['image']; ?>" alt="skins">
                    <p class="skin-name"><?php echo $skin['name']; ?></p>

                    <?php if ($skin['id'] == $myCurrentSkin) { ?>
                        <span class="skin-using">USING</span>

                    <?php } elseif ($myScore >= $skin['unlock_score']) { ?>

                        <button onclick="selectSkin(<?php echo $skin['id'] ?>)" class="btn">USE</button>

                    <?php } else { ?>

                        <span class="skin-locked"><?php echo $skin['unlock_score'] ?> PTS</span>

                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <a href="index.php" class="shop-back">← Back to Game</a>
    </div>
    <script>
        function selectSkin(x) {
            fetch("select_skin.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "skin_id=" + x
            });
            alert("Skin Selected");
        }
    </script>
</body>

</html>