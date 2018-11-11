<?php
	include_once "functions.php";

	$its_admin = checkUser();

	if (!empty($_GET)) {

		if (isset($_GET['Del']) && $its_admin) {
			
			$file_del = __DIR__ . '/tests/' . $_GET['Del'] . '.json';
			unlink($file_del);

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
		echo logoutText();
	?>

</body>
</html>
