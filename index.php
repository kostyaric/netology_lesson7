<?php
	
	session_start();

	if (!isset($_SESSION['name'])) {

		if (isset($_SERVER['PHP_AUTH_USER'])) {

			$_SESSION['name'] = $_SERVER['PHP_AUTH_USER'];
			$_SESSION['password'] = $_SERVER['PHP_AUTH_PW'];
			header("Location: list.php");

		}
		else {

			header('WWW-Authenticate: Basic realm="Admin"');
			http_response_code(401);
			exit;

		}
	}

?>
