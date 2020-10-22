<?php



	if( strpos(file_get_contents("./blocked"), $_SERVER['REMOTE_ADDR']) !== false) {
        echo "Your IP has been blocked from signing up. This could be due to usage of a VPN. Contact us.";
    }
	else if(isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])){
		$errors = array();
		
		$emailMaxLength = 254;
		$usernameMaxLength = 20;
		$usernameMinLength = 3;
		$passwordMaxLength = 512;
		$passwordMinLength = 5;
		
		$email = strtolower($_POST["email"]);
		$username = $_POST["username"];
		$password1 = $_POST["password"];
		
		//Validate email
		if(preg_match('/\s/', $email)){
			$errors[] = "Email can't have spaces";
		}else{
			if(!validate_email_address($email)){
				$errors[] = "Invalid email";
			}else{
				if(strlen($email) > $emailMaxLength){
					$errors[] = "Email is too long, must be equal or under " . strval($emailMaxLength) . " characters";
				}
			}
		}
		
		//Validate username
		if(strlen($username) > $usernameMaxLength || strlen($username) < $usernameMinLength){
			$errors[] = "Incorrect username length, must be between " . strval($usernameMinLength) . " and " . strval($usernameMaxLength) . " characters";
		}else{
			if(!ctype_alnum ($username)){
				$errors[] = "Username must be alphanumeric";
			}
		}
		
		//Validate password
	
		if(preg_match('/\s/', $password1)){
			$errors[] = "Password can't have spaces";
		}else{
			if(strlen($password1) > $passwordMaxLength || strlen($password1) < $passwordMinLength){
				$errors[] = "Incorrect password length, must be between " . strval($passwordMinLength) . " and " . strval($passwordMaxLength) . " characters";
			}else{
				if(!preg_match('/[A-Za-z]/', $password1) || !preg_match('/[0-9]/', $password1)){
					$errors[] = "Password must contain atleast 1 letter and 1 number";
				}
			}
		}
		
		require dirname(__FILE__) . '/database.php';


		//Check if there is user already registered with the same email or username
		if(count($errors) == 0){
			
			if ($stmt = $mysqli_conection->prepare("SELECT username, email FROM users WHERE email = ? OR username = ? LIMIT 1")) {
				
				/* bind parameters for markers */
				$stmt->bind_param('ss', $email, $username);
					
				/* execute query */
				if($stmt->execute()){
					
					/* store result */
					$stmt->store_result();

					if($stmt->num_rows > 0){
					
						/* bind result variables */
						$stmt->bind_result($username_tmp, $email_tmp);

						/* fetch value */
						$stmt->fetch();
						
						if($email_tmp == $email){
							$errors[] = "A user with this email already exists.";
						}
						else if($username_tmp == $username){
							$errors[] = "A user with this name already exists.";
						}
					}
					
					/* close statement */
					$stmt->close();
					
				}else{
					$errors[] = "Something went wrong, please try again. A1";
				}
			}else{
				$errors[] = "Something went wrong, please try again. A2";
			}
		}
		

		



		//Finalize registration
		if(count($errors) == 0){
			
			$encryptedPassword = password_hash($password1, PASSWORD_BCRYPT);

			//if($stmt = $mysqli_conection->prepare("INSERT INTO users (username, email, salt, password, ip) VALUES (?, ?, ?, ?, ?)")){
			//	$stmt->bind_param("sss", $firstname, $lastname, $email);
			//}

			if ($stmt = $mysqli_conection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)")){

				$stmt->bind_param("sss", $username, $email, $encryptedPassword);
	
				if($stmt->execute()){
					$mysqli_conection->query("UPDATE users SET wkey = '" . generateRandomString() . "' WHERE username = '" . $username . "'");
					
					$stmt->close();
				}else{
					$errors[] = "B1 " . $stmt->errid;
				}

			} else{
				$errors[] = "Something went wrong, please try again. B2";
			}
		}

		if(count($errors) > 0){
			echo $errors[0];
		}else{
			echo "Success";
		}
	} else{
		echo "Missing data. C1";
	}
	
	function validate_email_address($email) {
		return preg_match('/^([a-z0-9!#$%&\'*+-\/=?^_`{|}~.]+@[a-z0-9.-]+\.[a-z0-9]+)$/i', $email);
	}
?>

<?php

function generateRandomString($length = 10) {
    
    $length = 64;
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}