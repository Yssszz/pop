    <?php
    session_start();
    include("backend.php");

    if (!isset($_SESSION['username'])) {
        header('Location: ../pop/admin/redirect.php');
        exit;
    }

    $username = $_SESSION['username'];
    $stmt = $db->prepare("
    SELECT users.score, users.role, skins.image, skins.image_open 
    FROM users 
    JOIN skins ON users.current_skin = skins.id 
    WHERE users.username = ?
    ");
    $stmt->execute([$username]);
    $data = $stmt->fetch();

    $myScore = $data['score'];
    $myRole = $data['role'];
    $mySkinClosed = $data['image'];
    $mySkinOpen = $data['image_open'];
    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />


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

        <!-- Additional Fontawesome Pro+ Icons for v7.2.0 -->

        <!-- Sharp Duotone -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/sharp-duotone-solid.css" />
        <!-- Chisel -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/chisel-regular.css" />
        <!-- Etch -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/etch-solid.css" />
        <!-- Graphite -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/graphite-thin.css" />
        <!-- Jelly -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/jelly-regular.css" />
        <!-- Notdog -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/notdog-solid.css" />
        <!-- Slab -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/slab-regular.css" />
        <!-- Thumb Print -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/thumbprint-light.css" />
        <!-- Utility -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/utility-semibold.css" />
        <!-- Whiteboard -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizmyabdulla/fontawesome-pro@main/releases/v7.2.0/css/whiteboard-semibold.css" />
        <!-- Font Awesome CDN END -->

        <!-- Title Start -->
        <title>PoP Project</title>
        <!-- Title End -->
    </head>

    <body>
        <header>
            <nav>
                <div class="top">
                    <div class="left">
                        <div class="icon-cover">
                            <a href="shop.php">
                                <i class="fa-solid fa-shop"></i>
                            </a>
                        </div>
                        <div class="icon-cover">
                            <a href="leaderboard.php">
                                <i class="fa-solid fa-star"></i>
                            </a>
                        </div>
                        <?php if ($myRole == 1) { ?>
                            <div class="icon-cover" id="admin-dash">
                                <a href="../pop/admin/panel.php">
                                    <i class="fa-solid fa-user-crown"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="mid">
                        <h1 class="title"><span class="hl">POP</span><span id="hams">HAMS</span></h1>

                        <?php if ($_SESSION['role'] == 1) { ?>
                            <span class="admin-hi">Hi, <?php echo $_SESSION['username'] ?>, Welcome Back Admin.</span>
                        <?php } else { ?>
                            <span id="user-hi">Hi, <?php echo $_SESSION['username'] ?></span>
                        <?php } ?>

                        <span id="score"><?php echo $myScore; ?></span>
                    </div>

                    <div class="right">
                        <a href="../pop/pages/setting.php">
                            <div class="right-cover">
                                <i class="fa-whiteboard fa-semibold fa-gear"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <section>
            <div class="main">
                <img id="char"
                    src="<?php echo $mySkinClosed; ?>"
                    data-closed="<?php echo $mySkinClosed; ?>"
                    data-open="<?php echo $mySkinOpen; ?>">
            </div>
        </section>
        <script src="script.js"></script>
    </body>

    </html>