<?php
session_start();

if(isset($_SESSION['username'])){
    echo "You are currently logged in as " . $_SESSION['username'];
    echo ". <a href='times'>View Timezones</a>";
}else{
    echo "You are logged out.";
}?>

<hr>
Homepage coming soon. For now, you can <a href="/login">Login.</a>