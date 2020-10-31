<?php
session_start();
//echo "EDIT : DEBUG<br><br>";

require dirname(__FILE__) . '/api/database.php';

//print_r($_POST);

$id = $_POST['id'];
$offset = $_POST['offset'];
$name = $_POST['name'];
$description = $_POST['description'];

//echo "<br>ID is " . $description;
//echo "<br>Offset is " . $offset;
//echo "<br>Name is " . $name;
//echo "<br>Description is " . $description;


//echo "<br><br>Adding to database... If you don't see anything after this, that means it's failed.";

$stmt = $mysqli_conection->prepare("UPDATE times SET offset = ?, name = ?, description = ? WHERE id = ? AND owner = ?");
$stmt->bind_param("issii", $a = intval($offset), $name, $description, $c = intval($id), $b = intval($_SESSION['id']));
$stmt->execute();

//echo "<br>If your seeing this it was done correctly. I hope that worked lol";
//echo "<br><br><a href='times'>Go back to times</a>";

/* This will give an error. Note the output
 * above, which is before the header() call */
header('Location: https://timehub.hubza.co.uk/times');