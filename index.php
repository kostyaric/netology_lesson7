<?php
	
	include_once "functions.php";

	session_start();

	if (!isset($_SESSION['name'])) {
		
		if (!empty($_POST)) {
			
			if (!empty($_POST['user'])) {

				$_SESSION['name'] = $_POST['user'];
				$_SESSION['password'] = $_POST['login'];
				header("Location: list.php");

			}
			else {
				
				http_response_code(401);
				exit;

			}
		}
		else {
			$html = '
			<form action="" method="POST">
				
				<label>Имя
					<input type="text" name="user">
				</label>
				<label>Пароль
					<input type="password" name="login">
				</label>
				<input type="submit" name="bt_submit" value="Вход">

			</form>
			';
		}
	}
	else {
		$html = '
		<p>
		Вы вошли под именем: ' . $_SESSION['name'] . '
		</p>
		<a href="list.php">Перейти к списку тестов</a>' .
		logoutText();
		
	}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Авторизация</title>
	<meta charset="utf-8">
</head>
<body>
	<?php echo $html; ?>
</body>
</html>