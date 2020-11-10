<?php

ini_set('session.gc_maxlifetime', 694201337);
session_set_cookie_params(694201337);

session_start();

if(isset($_SESSION['username'])){
    echo "You are currently logged in as " . $_SESSION['username'];
    echo ". <a href='times'>View Timezones</a>";
}else{
    echo "You are logged out.";
    echo '<hr>
    Homepage coming soon. For now, you can <a href="/login">Login.</a>';
}?>

