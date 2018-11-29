<?php
mb_internal_encoding("UTF-8");
//подключение config.php
include_once "config.php"; 
/*
1) из-за маски длина строки номера м.б.т. 0 или 16,
2) script.js пропустит т. строку длиной 16 симв.
=> проверка не нужна
*/
echo "Вы ввели номер: " . $_POST['tel'];
