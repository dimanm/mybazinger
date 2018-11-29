<?php
mb_internal_encoding("UTF-8");
//подключение config.php
include_once "config.php"; 
// целевая проверка входящих данных
// если хотя бы один обязательный элемент _POST пустой, то ошибка, иначе ок
$enterData = array(
    $_POST['name'],
    $_POST['email']/*,
    $_POST['subject'],
    $_POST['message']*/
);
$er=false;
for ($i=0; $i < count($enterData); $i++) { 
	if (strlen($enterData[$i])==0) {
		$er=true;
		break;
	}
}
if ($er) {
	echo "error";
} else {
	//отправка письма
	$to = $_POST['email'];
	$subject = "Регистрация на Bazinger!";
	$t_send = date('Y-m-d H:i:s');
	$message = 
	"Поздравляем, " . $_POST['name'] . "!!!" .
	"\nВы зарегистрированы на " . $_SERVER['SERVER_NAME'] .
	"\nВремя открытия формы регистрации: " . $_POST['time'] .
	"\nДата регистрации: " . $t_send;
	$headers = "From: Bazinger";
	$ismail = mail($to, $subject, $message, $headers); 
	$ismail;
	if ($ismail) {
		//dt
		$t1 = strtotime($_POST['time']);
		$t2 = strtotime($t_send);
		$dt = 
			(($t2 - $t1) / 60 / 60 % 24) . ":" . 
			(($t2 - $t1) / 60 % 60) . ":" . 
			(($t2 - $t1) % 60);
		/*
		echo 'Время открытия формы: '. $_POST['time'] . '<br>';
		echo 'Время отправки формы: '. $t_send . '<br>';
		echo 'dt: ' . $dt . '<br>';
		*/
		//создание подключения к БД
		$link = mysqli_connect($db_host, $db_user, $db_password, $db_base) or die('Ошибка ' . mysqli_error($link));
		mysqli_set_charset($link ,'utf8');
		//запись в БД
		$query_insert = 
		'INSERT INTO messages (
			name, 
			email,
			subject, 
			message,
			t_open,
			t_send,
			dt 
		)  
		VALUES (
			"' . $_POST['name'] . '", 
			"' . $_POST['email'] . '",
			"' . $_POST['subject'] . '",
			"' . $_POST['message'] . '",
			"' . $_POST['time'] . '",
			"' . $t_send . '",
			"' . $dt . '"
		)';
		mysqli_query($link, $query_insert) or die('Ошибка' . mysqli_error($link));
		//закрыть подключения к БД
		mysqli_close($link);
		echo "ok";
	} else {
		echo "error-mail";
	};
}
/*
//вывод из БД
$query_select = 'SELECT * FROM messages';
$result = mysqli_query($link, $query_select) or die('Ошибка' . mysqli_error($link));
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo 
	$row["id"] . ', ' . 
	$row["name"]. ', ' .
	$row["email"]. ', '	;
}
mysqli_free_result($result);
*/
?>