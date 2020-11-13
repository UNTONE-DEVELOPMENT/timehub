<?php
$category = "page";
$site = "settings";


ini_set('session.gc_maxlifetime', 694201337);
session_set_cookie_params(694201337);

session_start();

include("generic.php");
require dirname(__FILE__) . '/api/database.php';


include("requirelogin.php");

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TimeHub • Times</title>
    <meta name="author" content="name">
    <meta name="description" content="none">
    <meta name="keywords" content="none">
    <link rel="stylesheet" href="<?php echo $category; ?>.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $site; ?>.css" type="text/css">
</head>

<body>
    <?php navbar(); ?>
    <div class="main-content">
        <div class="welcome">
            welcome to the settings page lol
        </div>
    </div>
</body>
