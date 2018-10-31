<?php

	$source_img = __DIR__ . '/img/salut.png';
	$font_file = __DIR__ . '/ttf/BadScript-Regular.ttf';

	if (!file_exists($source_img)) {
		echo 'Не найден исходный файл с картинкой';
		exit;
	}
	
	if (!file_exists($font_file)) {
		echo 'Не найден файл шрифта';
		exit;
	}

	if (!empty($_GET)) {
		$name = $_GET['username'];
		$mark = $_GET['mark'];
	}

	$text =  "Поздравляем, $name!\n Ваша оценка за выполнение теста = $mark\n по десятибальной шкале";
	$image = imagecreatetruecolor(960, 685);

	$back_color = imagecolorallocate($image, 200, 100, 100);
	$text_color = imagecolorallocate($image, 0, 0, 255);


	$img_box = imagecreatefrompng($source_img);

	imagefill($image, 0, 0, $back_color);
	imagecopy($image, $img_box, 0, 0, 0, 0, 900, 680);

	imagettftext($image, 26, 0, 50, 100, $text_color, $font_file, $text);

	header('Content-Type: image/png');
	imagepng($image);
	imagedestroy($image);

?>