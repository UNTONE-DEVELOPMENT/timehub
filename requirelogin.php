<?php


function _bot_detected() {

    return (
      isset($_SERVER['HTTP_USER_AGENT'])
      && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
    );
  }

session_start();


if(isset($_SESSION['username'])) {

}else{
    if(!_bot_detected()){
        echo "Redirecting to login. If you do not get redirected <a href='./login'>click here.</a>";
        header('Location: https://timehub.hubza.co.uk/login?redirect=' . $_SERVER['REQUEST_URI']);
    }
} 

?>