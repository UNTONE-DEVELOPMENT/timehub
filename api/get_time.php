<?php

	session_start();
	if(isset($_GET["wkey"]) && isset($_GET["id"])){
		$errors = array();
		
		$wkey = $_GET["wkey"];
		$id = $_GET["id"];

		//Connect to database
		require dirname(__FILE__) . '/database.php';

		$stmt1 = $mysqli_conection->prepare("SELECT * FROM `users` WHERE wkey = ?");
		$stmt1->bind_param("s", $wkey);
	
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		while ($row = $result1->fetch_assoc()) {
			$username = $row['username'];
		}

		if(isset($username)){
			$sql = "SELECT * FROM times WHERE id = ?";
			$stmt = $mysqli_conection->prepare($sql);
			$stmt->bind_param("s", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				header('Content-Type: application/json');
				echo json_encode($row);
			}
		}else{
			echo "Wrong WKEY";
		}
	}
?>