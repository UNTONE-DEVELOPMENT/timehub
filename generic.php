<?php

ob_start();
if($gogo == false){
  echo '<head>
  <link rel="stylesheet" href="https://timehub.hubza.co.uk/main.css" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"
      integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg=="
      crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
  <link rel="apple-touch-icon" sizes="180x180" href="e">
  <link rel="icon" sizes="32x32" href="e">
  <link rel="manifest" href="/site.webmanifest">
  <meta name="msapplication-TileColor" content="#3d49ec">
  <meta name="theme-color" content="#3d49ec">
  <meta property="og:image" content="e">
  <meta name="viewport" content="width=device-width, initial-scale=0.5">
</head>
';
}

function navbar(){
    include("navbar.php");
}

function time_elapsed_string($timestamp, $full = false) {
    date_default_timezone_set("GMT");    

    

    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $current_time += 7200;
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;

  
    
    $minutes = round($seconds / 60); // value 60 is seconds  
    $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
    $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
    $weeks   = round($seconds / 604800); // 7*24*60*60;  
    $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
    $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

    // echo "<br>Minutes: ". $minutes;
    // echo "<br>Hours: ". $hours;
    // echo "<br>Days: ". $days;
    // echo "<br>Weeks: ". $weeks;
    // echo "<br>Months: ". $months;
    // echo "<br>Years: ". $years;
    // echo "<br>Time: " . $current_time;
    // echo "<br>Sent Time: " . $timestamp;     
    // echo "<br>Parsed Time: " . $time_ago; 

    if ($seconds <= 60){
  
      return "just now";
  
    } else if ($minutes <= 60){
  
      if ($minutes == 1){
  
        return "one minute ago";
  
      } else {
  
        return "$minutes minutes ago";
  
      }
  
    } else if ($hours <= 24){
  
      if ($hours == 1){
  
        return "an hour ago";
  
      } else {
  
        return "$hours hrs ago";
  
      }
  
    } else if ($days <= 7){
  
      if ($days == 1){
  
        return "yesterday";
  
      } else {
  
        return "$days days ago";
  
      }
  
    } else if ($weeks <= 4.3){
  
      if ($weeks == 1){
  
        return "a week ago";
  
      } else {
  
        return "$weeks weeks ago";
  
      }
  
    } else if ($months <= 12){
  
      if ($months == 1){
  
        return "a month ago";
  
      } else {
  
        return "$months months ago";
  
      }
  
    } else {
      
      if ($years == 1){
  
        return "one year ago";
  
      } else {
  
        return "$years years ago";
  
      }
    }

    
}


$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/error.php";
//include_once($path);
//throw new Exception('pause for maintenance');