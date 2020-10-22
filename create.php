<?php
session_start();
require dirname(__FILE__) . '/api/database.php';

print_r($_POST);

$offset = $_POST['offset'];
$name = $_POST['name'];
$description = $_POST['description'];
$summer = $_POST['summer'];

if($summer == "on"){ 
    $offset = $offset - 1;
    echo "<br><br>It was summertime. Offset was subtracted by one. It'll be sorted in runtime instead.<br>";
    $summer = 1;
}else{
    $summer = 0;
}

echo "<br>Summer is " . $summer;
echo "<br>Offset is " . $offset;
echo "<br>Name is " . $name;
echo "<br>Description is " . $description;
echo "<br>";
echo "<br>1 is ";
print_r(intval($offset));
echo "<br>";
echo gettype(intval($offset));
echo "<br>2 is ";
print_r($name);
echo "<br>";
echo gettype($name);
echo "<br>3 is ";
print_r($description);
echo "<br>";
echo gettype($description);
echo "<br>4 is ";
print_r(intval($_SESSION['id']));
echo "<br>";
echo gettype(intval($_SESSION['id']));
echo "<br>5 is ";
print_r("user");
echo "<br>";
echo gettype("user");
echo "<br>6 is ";
print_r(intval($summer));
echo "<br>";
echo gettype(intval($summer));

echo "<br><br>Adding to database... If you don't see anything after this, that means it's failed.";

$stmt = $mysqli_conection->prepare("INSERT INTO `times` (`id`, `offset`, `name`, `description`, `creation-date`, `owner`, `type`, `summer`) VALUES (NULL, ?, ?, ?, current_timestamp(), ?, ?, ?);");
$stmt->bind_param("issisi", $a = intval($offset), $name, $description, $b = intval($_SESSION['id']), $c = "user", $d = intval($summer));
$stmt->execute();

echo "<br>If your seeing this it was done correctly. I hope that worked lol";
echo "<br><br><a href='times'>Go back to times</a>";