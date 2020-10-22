<head>
    <link rel="stylesheet" href="https://timehub.hubza.co.uk/navbar.css" type="text/css">
</head>


<div class="navbar">
    <div class="navbar-inner">
        <div class="logo">
            <span class="time logo-text">Time</span><span class="hub logo-text">Hub</span>
        </div>
        <?php if(isset($_SESSION['username'])) {?>

        <p class="user">logged in as <span class="username">
                <?php echo $_SESSION['username'];?></span>
            </p>



            <?php }else{ ?>

            <a class="login"
                href="https://timehub.hubza.co.uk/login?redirect=<?php echo $_SERVER['REQUEST_URI'];; ?>">Login</a>
            <?php } ?>
    </div>
</div>