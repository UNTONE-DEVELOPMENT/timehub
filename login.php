<?php
$category = "account";
$site = "login";

session_start();

include("generic.php");

function contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

if (isset($_POST['email'])) {
    $post = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    $ch = curl_init('https://timehub.hubza.co.uk/api/login.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    // close the connection, release resources used
    curl_close($ch);

    $arrData = explode("|", $response);

    $_SESSION['success'] = $arrData[0];
    $_SESSION['username'] = $arrData[1];
    $_SESSION['email'] = $arrData[2];
    $_SESSION['id'] = $arrData[3];
    $_SESSION['wkey'] = $arrData[4];

    $redirect = htmlspecialchars($_GET["redirect"]);
    

    if(contains("ucces", $_SESSION['success'])){
        if(isset($redirect)){
            header('Location: ' . $redirect,  true,  301); exit;
        }else{
            header('Location: https://timehub.hubza.co.uk',  true,  301); exit;
        }
    }
}
?>

<?php
    if(($_SESSION['username'])){
        if(isset($redirect)){
            header('Location: ' . $redirect,  true,  301); exit;
        }else{
            header('Location: https://timehub.hubza.co.uk',  true,  301); exit;
        }
    }
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TimeHub • Login</title>
    <meta name="author" content="name">
    <meta name="description" content="none">
    <meta name="keywords" content="none">
    <link rel="stylesheet" href="<?php echo $category; ?>.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $site; ?>.css" type="text/css">
</head>

<body>
    <div class="ppanel-main">
        <div class="left">
        
        </div>
        <div class="right">
            <h1 class="right-text">Login to TimeHub</h1>
            <h1 class="right-text-2">Login to your TimeHub account to continue!</h1>
            <div class="divider"></div>
            <form method="POST" class="form">
                <p class="input-header">Your Email</P>
                <input class="login-input" type="email" id="email" name="email">
                <p class="input-header">Your Password</P>
                <input class="login-input" type="password" id="password" name="password">
  
                <input type="submit" class="abutton" href="e" value="Login">

                <p style="color: red; margin-top: 4px;"><?php echo $_SESSION['success'];?></p>
            </form>
            <p class="dont">Don't have an account? <a href="register">Why not register one?</a></p>
        </div>
    </div>
</body>