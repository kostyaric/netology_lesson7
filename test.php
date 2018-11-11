<?php

	include_once "functions.php";
	checkUser();

	$result_string = '';

	if (!empty($_GET)) {
		if (array_key_exists('ID', $_GET)) {

			$testnum = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
			if ($testnum === false) {
				http_response_code(404);
				echo 'Неправильное имя файла с тестом. Должно быть число';
				exit;
			}
			else {
				
				$file_name = __DIR__ . '/tests/' . $testnum . '.json';

				if (!file_exists($file_name)) {
						http_response_code(404);
						echo 'Не найден файл с указанным номером теста';
						exit;
					}
			}

			$jstring = file_get_contents($file_name);
			$jdata = json_decode($jstring, true);
			$testname = $jdata['testname'];
			$questionset = $jdata['questionset'];

			$field_string = '';
			foreach ($questionset as $i => $single_question) {

				$question_num = $i + 1;
				$question = $single_question['question'];
				$answers = $single_question['answers'];

				$answer_string = '';
				foreach ($answers as $choise) {
					
					$choise = $choise[0];
					$answer_string .= '
					<label><input type="radio" name="choise' . $i . '" value="' . $choise . '">' . $choise . '</label>';
				}

				$field_string .= "
				<fieldset>
				    <legend>Вопрос № $question_num. $question</legend>" .
					    $answer_string .
				'</fieldset>';
			}
		}
	}
	if (!empty($_POST)) {
		
		$mistake_string = '';
		$username = $_SESSION['name'];
		$test_count = 0;
		$true_answers = 0;


		if (empty($username)) {
			$mistake_string .= '<p>Не указано имя пользователя</p>';
		}

		foreach ($questionset as $i => $single_question) {
			
			$test_count++;
			$answer_num = $i + 1;
			
			if (array_key_exists('choise' . $i, $_POST)) {

				$user_answer = $_POST['choise' . $i];
				
				$answers = $single_question['answers'];				
				foreach ($answers as $file_answer) {
					
					$value = $file_answer[0];

					if ($user_answer == $value) {
						$true_value = $file_answer[1];
						$true_answers += $true_value;
					}
				}

				$result_string .= '<p>Ваш ответ на вопрос № ' . $answer_num . ': ' . $user_answer . '. Это ' . ($true_value ? 'Правильный' : 'Ошибочный') . ' ответ </p>';
			}
			else {
				
				$mistake_string .= '<p>Вы не ответили на вопрос №' . $answer_num . '</p>';

			}

		}

		$mark = (int)($true_answers / $test_count * 10);

	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Тест</title>
	<meta charset="utf-8">
</head>
<body>
	<h1><?php echo $testname?></h1>
	<form action="" method="POST">
		<?php
		echo '<input type="hidden" name="ID" value="' . $testnum . '">';
		echo $field_string;
		?>
		<input type="submit" name="send">
	</form>
	<?php
	if (empty($mistake_string)) {
		echo $result_string;
		if (!empty($_POST)) {
			echo '<img src="congrats.php?username=' . $username . '&mark=' . $mark . '">';		
		}
	}
	else {
		echo $mistake_string;
	}
	?>
</body>
</html>

