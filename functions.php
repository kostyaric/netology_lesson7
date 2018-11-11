<?php
function checkUser($adminOnly = false) {

	session_start();

	if (!isset($_SESSION['name'])) {
		http_response_code(403);
		exit;
	}

	$admin = false;
	$file = __DIR__ . '/users/' . $_SESSION['name'] . '.json';

	if (file_exists($file)) {
		
		$user_string = file_get_contents($file);
		$user_data = json_decode($user_string, true);

		if (isset($_SESSION['password'])) {
			
			if ($user_data['password'] === $_SESSION['password']) {
				$admin = true;
			}

		}
	}

	if ($adminOnly && !$admin) {
		http_response_code(403);
		exit;
	}

	return $admin;
}

function logoutText() {

	return '
	<form action="logout.php" method="POST">
		<input type="submit" name="logout" value="Выход">
	</form>';

}

?>