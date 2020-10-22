<?php

	session_start();
	if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST['password']) ){
		$errors = array();
		
		$email = $_POST["email"];
		$password = $_POST["password"];

		$wkey = "uh oh";
		
		//Connect to database
		require dirname(__FILE__) . '/database.php';
		$mysqli = $mysqli_conection; // had to do this. not sure why, but not doing it broke it.
		
		$sql = "SELECT username, email, password, user_id, wkey FROM users WHERE email=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$username_tmp = $row['username'];
			$email_tmp = $row['email'];
			$password_tmp = $row['password'];
			$id_temp = $row['user_id'];
			$wkey = $row['wkey'];
		}

		if(password_verify($password, $password_tmp)){ // verifies the password using the password_verify function; checks the posted email address against the email address from the database.
				
			echo "Success" . "|" . $username_tmp . "|" .  $email_tmp . "|" . $id_temp . "|" . $wkey;
			//$mysqli_conection->query("UPDATE users SET ip = '" . $ip . "' WHERE username = '" . $username_tmp . "'");
			

			return;
		}else{
			$errors[] = "Wrong email or password.";
		}
			
		/* close statement */
		$stmt->close();

		if(count($errors) > 0){
			echo $errors[0];
		}
		
	}else{
		echo "Missing data";
	}
?>