<?php
	
	session_start();

	if (!isset($_SESSION['name'])) {
		http_response_code(403);
		exit;
	}

	if (!empty($_GET)) {

		if (isset($_GET['Del'])) {
			
			$file_del = __DIR__ . '/tests/' . $_GET['Del'] . '.json';
			unlink($file_del);

		}

	}

	$its_admin = false;
	$users_file = __DIR__ . '/users.json';

	if (file_exists($users_file)) {
		
		$users_string = file_get_contents($users_file);
		$users_data = json_decode($users_string, true);

		if (isset($_SESSION['password'])) {
			
			foreach ($users_data as $user) {
				
				$login = $user['name'];
				$password = $user['password'];

				if (($login === $_SESSION['name']) && ($password === $_SESSION['password'])) {
					
					$its_admin = true;

				}

			}

		}
	}

	$arrFiles = scandir('tests');
	$list_string = '';

	foreach ($arrFiles as $fullname) {

		if (substr($fullname, -5) === '.json') {

			$jstring = file_get_contents(__DIR__ . '/tests/' . $fullname);
			$jdata = json_decode($jstring, true);
			$testname = $jdata['testname'];

			$dotpos = strrpos($fullname, '.');
			$name = substr($fullname, 0, $dotpos);
			$list_string .= 
			'<div>
				<a href="test.php?ID=' . $name .'" target="_blank">' . $testname . '</a>';
				if ($its_admin) {
					$list_string .= 
					'<a href="list.php?Del=' . $name .'">&nbsp;Удалить</a>';
				}
			$list_string .= 
			'</div>';
		}

	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Список файлов</title>
	<meta charset="utf-8">
</head>
<body>

<h1>Список тестов</h1>
<?php
	echo $list_string;
	if ($its_admin) {
		echo '<a href="admin.php">Добавить тест</a>';
	}
?>

</body>
</html>
