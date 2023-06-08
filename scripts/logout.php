<?php
	session_start();
	if (isset($_SESSION["logged"])){
		session_start();
		unset($_SESSION["logged"]);
		//session_destroy();
		$_SESSION["success"] = "Prawidłowo wylogowano użytkownika";
	}

	header("location: ../pages");

