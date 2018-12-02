<?php
//параметры для подключения к БД
$driver = 'mysql'; //имя СУБД
$db_host = 'localhost'; //имя хоста
$db_user = 'root'; // логин БД
$db_password = ''; // пароль БД
$db_name = 'land_form'; // имя БД
$charset = 'utf8'; // кодировка
$fetch_how = PDO::FETCH_ASSOC; //представление выборки
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; //стратегия обработки ошибок
/*при ошибке скрипт останавливается и выбрасывается соотв. исключение*/
?>