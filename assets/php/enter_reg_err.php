<?php
mb_internal_encoding("UTF-8");
//проверка правиьности заполнения полей
$enterData = array(
	array('"Your Name"', $_POST['name']),
	array('"You Email"', $_POST['email'])
);
$enterErr = false;
for ($i=0; $i < count($enterData); $i++) { 
	if (strlen($enterData[$i][1])==0) {
		echo 'поле '.$enterData[$i][0].' не заполнено'.'<br>';
		$enterErr = true;
	} else {
		if (strlen($enterData[$i][1])<5 || strlen($enterData[$i][1])>30) {
			echo 'поле '.$enterData[$i][0].' должно содержать 5-30 символов'.'<br>';
			$enterErr = true;
		};
		if (
			(strcasecmp($enterData[$i][0],'"Your Name"')==0) && (preg_match('/\d+/',$enterData[$i][1])==1)
		) {
			echo 'поле '.$enterData[$i][0].' не должно содержать цифр'.'<br>';
			$enterErr = true;
		};
		if (
			(strcasecmp($enterData[$i][0],'"You Email"')==0) && (preg_match('/\S+@\S+\.\S+/',$enterData[$i][1])==0)
		) {
			echo 'поле '.$enterData[$i][0].' заполнено неправильно '.'<br>';
			$enterErr = true;
		};
	};
};
if($enterErr) die("пожалуйста, заполните форму правильно");
/*
часть 
"...else {
	действия в случае правильно заполненных полей
}" не нужна, т.к. при !die("Не заполнены обязательные поля");
последует выполнение нижележащих операций
*/
?>