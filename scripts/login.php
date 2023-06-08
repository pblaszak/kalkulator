<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		session_start();
		foreach ($_POST as $value){
			if (empty($value)){
				$_SESSION["error"] = "Wypełnij wszystkie pola!";
				echo "<script>history.back();</script>";
				exit();
			}
		}

		require_once "./connect.php";

		try {
			$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");

			$stmt->bind_param("s", $_POST["email"]);

			$stmt->execute();

			$result = $stmt->get_result();
		//	echo $result->num_rows;

			if ($result->num_rows != 0){
				$user = $result->fetch_assoc();
				//echo $user["password"];
				if (password_verify($_POST["pass"], $user["password"])){
					//echo "zalogowany";
					$_SESSION["logged"]["firstName"] = $user["firstName"];
					$_SESSION["logged"]["lastName"] = $user["lastName"];
					$_SESSION["logged"]["logo"] = $user["logo"];
					$_SESSION["logged"]["session_id"] = session_id();
					//echo session_id();

					//czas sesji
					$sessionLifeTime = ini_get("session.gc_maxlifetime");
					//echo $sessionLifeTime; //1440  =>  24 minuty
					$sessionLifeTimeFormated = gmdate('i', 1800);
					//echo $sessionLifeTimeFormated; //sesja jest ustawiona na 30 minut
					//session_status() => 0, 1, 2  => 2 - jest prawidłowa

					$_SESSION["logged"]["role_id"] = $user["role_id"];
					$_SESSION["logged"]["last_activity"] = time();
					//echo $_SESSION["logged"]["last_activity"];
					//print_r($_SESSION["logged"]);

					//logs
					$status = 1;
//					$address_ip = $_SERVER["SERVER_ADDR"];
					$address_ip = $_SERVER["REMOTE_ADDR"];

					$sql = "INSERT INTO `logs` (`user_id`, `status`, `address_ip`) VALUES (?, ?, ?);";
					$stmt->prepare($sql);
					$stmt->bind_param("iss", $user["id"], $status, $address_ip);
					$stmt->execute();

					header("location: ../pages/views/logged.php");
					exit();

				}else{
					//echo "niezalogowany";
					$_SESSION["error"] = "Błędny login lub hasło!";
					$status = 0;
//					$address_ip = $_SERVER["SERVER_ADDR"];
					$address_ip = $_SERVER["REMOTE_ADDR"];


					$sql = "INSERT INTO `logs` (`user_id`, `status`, `address_ip`) VALUES (?, ?, ?);";
					$stmt->prepare($sql);
					$stmt->bind_param("iss", $user["id"], $status, $address_ip);
					$stmt->execute();

					echo "<script>history.back();</script>";
					exit();
				}
			}else{
				$_SESSION["error"] = "Błędne logowanie!";
				echo "<script>history.back();</script>";
			}

		} catch (mysqli_sql_exception $e) {
			$_SESSION["error"] = $e->getMessage();
			echo "<script>history.back();</script>";
		}
	}

	header("location: ../pages");