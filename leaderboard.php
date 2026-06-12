<?php
session_start();
include "backend.php";

if (!isset($_SESSION['username'])) {
    header('Location: ../pop/admin/redirect.php');
    exit;
}

$stmt = $db->query("SELECT `username`, `score` FROM users ORDER BY score DESC");
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="lead.css">
    <title>Leaderboard</title>
</head>

<body>
    <div class="lb-wrap">
        <div class="lb-card">
            <h1 class="lb-title">LEADERBOARD</h1>

            <?php if (empty($players)) { ?>
                <p class="lb-empty">No Player Yet.</p>
            <?php } else { ?>
                <?php $rank = 1 ?>
                <?php foreach ($players as $player) { ?>
                    <div class="lb-row">
                        <span class="lb-rank"><?php echo $rank ?></span>
                        <span class="lb-name"><?php echo $player['username'] ?></span>
                        <span class="lb-score"><?php echo $player['score'] ?></span>
                    </div>
                    <?php $rank++; ?>
                <?php } ?>
            <?php } ?>

            <a href="index.php" class="lb-back">← Back to Game</a>
        </div>
        <div class="random">
            <div class="img">
                <img src="assets/img/randomcat.png" alt="random">
            </div>
        </div>
    </div>
</body>

</html>