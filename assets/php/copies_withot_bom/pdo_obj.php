<?php
mb_internal_encoding("UTF-8");
/*
объект PDO - запись с полями: 
соединение; 
функции, раб. с СУБД;
настройки БД
*/
class database{
	private $link; //соединение
	//Вызов функции, устанавливающей соединение
	public function __construct(){
		$this->connect();
	}
	//функция, устанавливающая соединение
	private function connect(){
		//параметры для подключения к БД
		include_once "config.php";
		//data source name (имя источника данных)
		$dsn = "$driver:host=$db_host;dbname=$db_name;charset=$charset";
		try {
			$this->link = new PDO($dsn, $db_user, $db_password, $options);
			return $this;
		} catch(PDOException $e) {
			die("ошибка подключения PDO к СУБД");
		};
	}
	/*
	перед выполнением запроса с передачей значений параметрам в БД
	сначала осущ. планирование этого запроса (подготовка к его исполнению)
	(+экранирование глухой части данных)
	для этого передается переменная (подготавленный(щий) запрос), содержащая запрос + настройки его выполнения
	*/	
	//функция, отпр. подготовленный запрос в СУБД
	public function execute($sql /*шаблон запроса с плейсхолдерами параметров*/){		
		$cq = $this->link->prepare($sql); //подготовленный запрос
		return $cq->execute(); //исполнение подготовленного запроса 
	}
	//функция, возвр. результат запроса без передачи значений параметрам в БД
	public function query($sql,$fetchWhat,$fetchHow){
		$cq = $this->link->prepare($sql);
		$cq->execute();		
		if ($fetchWhat=="first") {
			$result = $cq->fetch($fetchHow);
		} else if ($fetchWhat=="all") {
			$result = $cq->fetchAll($fetchHow);
		} else {
			die("Неправильно указан fetchWhat");
		};
		return $result;
	}
};
/*
соединение с СУБД - потомок объекта PDO =>
1) установка соединение <- создание данного объекта
2) обрыв соединения <- уничтожение данного объекта
$db = new database();...unset($db); - скобки сущ. соединения
*/
?>