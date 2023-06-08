<?php
session_start();
//	echo "<pre>";
//		print_r($_POST);
//	echo "</pre>";

foreach ($_POST as $value){
	if (empty($value)){
		$_SESSION["error"] = "Wypełnij wszystkie pola!";
		echo "<script>history.back();</script>";
		exit();
	}
}

$error = 0;
if (!isset($_POST["terms"])){
	$error = 1;
	$_SESSION["error"] = "Zatwierdź regulamin!";
}

if ($_POST["pass1"] != $_POST["pass2"]){
	$error = 1;
	$_SESSION["error"] = "Hasła są różne!";
}

if ($_POST["email1"] != $_POST["email2"]){
	$error = 1;
	$_SESSION["error"] = "Adresy poczty elektronicznej są różne!";
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s])\S{2,}$/', $_POST["pass1"])){
	$error = 1;
	$_SESSION["error"] = "Hasło nie spełnia wymagań co do złożoności!";
}

if ($error != 0){
	echo "<script>history.back();</script>";
	exit();
}

require_once "./connect.php";

try {
	$stmt = $conn->prepare("INSERT INTO `users` (`city_id`, `email`, `firstName`, `lastName`, `birthday`, `password`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, current_timestamp());");

	$pass = password_hash($_POST["pass1"], PASSWORD_ARGON2ID);

	$stmt->bind_param("isssss", $_POST["city_id"], $_POST["email1"], $_POST["firstName"], $_POST["lastName"], $_POST["birthday"], $pass);

	$stmt->execute();

	if ($stmt->affected_rows == 1){
		$_SESSION["success"] = "Dodano użytkownika $_POST[firstName] $_POST[lastName]";
		header("location: ../pages");
		exit();
	}else{
		$_SESSION["error"] = "Nie dodano użytkownika";
		echo "<script>history.back();</script>";
		exit();
	}
} catch (mysqli_sql_exception $e) {
		$_SESSION["error"] = $e->getMessage();
		echo "<script>history.back();</script>";
}


