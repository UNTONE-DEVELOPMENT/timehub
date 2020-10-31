<?php
session_start();
require dirname(__FILE__) . '/api/database.php';
$id = $_POST['id'];

$stmt = $mysqli_conection->prepare("DELETE FROM times WHERE id = ? AND owner = ?");
$stmt->bind_param("ii", $c = intval($id), $b = intval($_SESSION['id']));
$stmt->execute();

header('Location: https://timehub.hubza.co.uk/times');