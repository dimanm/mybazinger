<?php
mb_internal_encoding("UTF-8");
include_once "enter_reg_err.php"; //проверка правиьности заполнения полей
include_once "pdo_obj.php"; //подключние интерфейса PDO

//время
$t_send = date('Y-m-d H:i:s');
/*
echo 'Время открытия формы: '. $_POST['time'] . '<br>';
echo 'Время отправки формы: '. $t_send . '<br>';
echo 'dt: ' . $dt . '<br>';
*/
/*
$t1 = strtotime($_POST['time']);
$t2 = strtotime($t_send);
$dt = 
	(($t2 - $t1) / 60 / 60 % 24) . ":" . 
	(($t2 - $t1) / 60 % 60) . ":" . 
	(($t2 - $t1) % 60);
echo 'dt1: ' . $mydt . '<br>';
*/
$t1 = new DateTime($_POST['time']);
$t2 = new DateTime($t_send);	
$dt = $t1->diff($t2);
//$dt = $dt->format('%R%Y лет, %R%M месяцев, %R%D дней, %R%H часов, %R%I минут,%R%S секунд');
$dt = $dt->format('%Y.%M.%D %H:%I:%S');
//echo 'dt2: ' . $dt . '<br>';
//echo strlen($dt) . '<br>';

/*
валидация имени:
ЕСЛИ длина>0 ТО
ЕСЛИ не имеет цифр ТО
ЕСЛИ уникально в таблице БД ТО
валидно ИНАЧЕ инвалидно 
*/
//фильтр уникальности имени
$db = new database();
	$name_err=$db->query("SELECT name FROM messages WHERE name='".$_POST['name']."'","all",PDO::FETCH_ASSOC);
	//echo count($name_err);
	//var_dump($name_err); 
	if (count($name_err)!=0){
		die ("Данное имя занято");
	} else {
		//echo "Данное имя не занято"."<br>"."Вы зарегистрированы"."<br>";//без script.js
		echo "Данное имя не занято\nВы зарегистрированы\n";//со script.js
		//генерация и шифрование пароля
		$psw = "";
		$salt="";
		$pswLength = rand(5,10);
		for($i=0; $i < $pswLength; $i++){
			$psw.=chr(rand(33,126)); //обычные символы ASCII
		};
		$saltLength = rand(4,8);
		for($i=0; $i < $saltLength; $i++){
			$salt.=chr(rand(33,126));
		};
		//запись в БД
		$db->execute("
			INSERT INTO messages (
				name, 
				email,
				subject, 
				message,
				t_open,
				t_send,
				dt,
				psw_img,
				salt
			) 
			VALUES (
			'" . $_POST['name'] . "', 
			'" . $_POST['email'] . "',
			'" . $_POST['subject'] . "',
			'" . $_POST['message'] . "',
			'" . $_POST['time'] . "',
			'" . $t_send . "',
			'" . $dt . "',
			'" . md5($psw.$salt) ."',
			'" . $salt ."'
			)
		");
	};
unset($db);
/*
часть 
"...else {
	действия в случае правильно заполненных полей
}" не нужна, т.к. при !die("Не заполнены обязательные поля");
последует выполнение нижележащих операций
*/

//отправка письма на почту
$to = $_POST['email'];
$subject = "Регистрация на Bazinger!";
$message = 
	"Поздравляем, " . $_POST['name'] . "!!!" .
	"\nВы зарегистрированы на " . $_SERVER['SERVER_NAME'] .
	"\nВыш пароль: " . $psw .
	"\nВремя открытия формы регистрации: " . $_POST['time'] .
	"\nДата регистрации: " . $t_send;
$headers = "From: 93dimi93@gmail.com";
$ismail = mail($to, $subject, $message, $headers); 
$ismail;
if ($ismail) {
	echo ("На почту ".$to." отправлено письмо");
} else {
	die ("Не удалось отправить письмо на почту ".$to);
}
?>