<?php
mb_internal_encoding("UTF-8");
include_once "enter_enter_err.php"; //проверка правильности заполнения полей
if (strlen($_POST['tel'])!=16) {
    die("Укажите телефон");
} else {
    include_once "pdo_obj.php"; //подключние интерфейса PDO
    $db = new database();
    $cell=$db->query("SELECT salt, psw_img FROM messages WHERE name='".$_POST['name']."'","first",PDO::FETCH_ASSOC);
    //echo count($cell);
    //var_dump($cell); 
    if (count($cell)!=0){
        echo "Пользователь с таким именем зарегестрирован\n";
        //проверка образов паролей
        //echo $cell["psw_img"].'<br>';
        //echo md5($_POST['password'].$cell["salt"]).'<br>';
        if (strcasecmp($cell["psw_img"],md5($_POST['password'].$cell["salt"]))==0){
            echo "На номер: " . $_POST['tel'] . " отправлен ключ";
            $db->execute("UPDATE messages SET tel='".$_POST['tel']."'WHERE name='".$_POST['name']."'");
            unset($db);
        } else {
            echo "Неверный пароль\nПожалуйста, повторите попытку или зарегистрируйтесь";
        };
    } else {
        echo "Пользователь с таким именем не зарегестрирован\nПожалуйста, повторите попытку или зарегистрируйтесь";
    };
};