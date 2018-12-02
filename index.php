<?php
mb_internal_encoding("UTF-8");
//сам файл имеет кодировку UTF-8 with BOM
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link href="./assets/css/normalize.css" rel="stylesheet">
	<link href="./assets/css/fonts.css" rel="stylesheet">
	<link href="./assets/js/slick/slick.css" rel="stylesheet">
    <link href="./assets/js/slick/slick-theme.css" rel="stylesheet">
    <link href="./assets/js/fancybox/dist/jquery.fancybox.css" rel="stylesheet">
    <link href="./assets/css/magnific-popup.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <link href="./assets/css/media.css" rel="stylesheet">
    <link href="./assets/css/placeholders.css" rel="stylesheet">
	<title>Bazinger</title>
</head>
<body>
<!--site-header-->
<header class="site-header">
	<div class="container">
		<a href="/" class="site-header__logo"><img src="./assets/img/logo.png"></a>
		<nav class="main-menu">
			<ul>
				<li><a href="index.php?floor=home">home</a></li>        
				<li><a href="index.php?floor=features">features</a></li>
				<li><a href="index.php?floor=gallery">gallery</a></li>
				<li><a href="index.php?floor=video">video</a></li>
				<li><a href="index.php?floor=prices">prices</a></li>
				<li><a href="index.php?floor=testimonials">testimonials</a></li>
				<li><a href="index.php?floor=download">download</a></li>
				<li><a href="index.php?floor=contact">contact</a></li>
			</ul>  
		</nav>
	</div>
</header>
<?
include_once "assets/php/copies_withot_bom/pdo_obj.php";
$db = new database();
switch ($_GET["floor"]) {
	case "":
	case "home":
		$floor=$db->query("SELECT html FROM floors","all",PDO::FETCH_ASSOC);
		for ($i=0; $i < count($floor); $i++) { 
			echo $floor[$i]["html"];
		};
		break;
	case "download":
		echo '<style>
			.site-map {display: none; }
			.site-header {background: #414042; }
			.download{
				min-height: calc(100vh - 200px); 
				justify-content: center;
			}
		</style>';
		break;
	case "contact":
		echo '<style>
			.download {display: none; }
			.site-header {background: #414042; }
			.ymap,.site-map {min-height: calc(100vh - 200px); }
		</style>';
		break;
	default:
		$floor=$db->query("SELECT html FROM floors WHERE floor_name='".$_GET["floor"]."'","first",PDO::FETCH_ASSOC);
		echo $floor["html"];
		echo '<style>
			.site-header {background: #414042; }
			.download,.site-map {display: none; }
			.site-level,.site-video {
				min-height: calc(100vh - 200px); 
				align-items: center;
				justify-content: center; }
		</style>';
		//-200px чтобы на экране умещались хидер и футер
		break;
}
unset($db);
?>
<!--site-download-->
<div class="download">
	<div>Do you Like this app?</div>
	<a href='form[name="form__dwn"]'>download now</a> 
</div>
<!--site-map-->
<div class="row site-map">
	<div id="map" class="ymap"></div>
	<form name="form__reg" method="post" action="./assets/php/ajaxForm.php">
		<label name="form__name">Contact</label>
		<!--type:email->text и "requared" убраны, т.к. поля проверяются в script.js-->
		<input type="text" name="name" placeholder="Your name">
		<label name="name__err-msg1">Укажите имя</label>
		<label name="name__err-msg2">Укажите имя от 5 до 30 символов</label>
		<label name="name__err-msg3">Имя не должно содержать цифр</label>
		<input type="text" name="email" placeholder="Your email" maxlength="30">
		<label name="email__err-msg1">Укажите адрес своей почты</label>
		<label name="email__err-msg2">Неправильно указан адрес почты</label>
		<input type="text" name="subject" placeholder="Subject" maxlength="30">
		<textarea type="text" name="message" placeholder="Message" maxlength="1000"></textarea>
		<button type="submit" name="button">Send</button>
		<input name="time" type="hidden" value="<? echo date('Y-m-d H:i:s'); ?>">
		<label name="form__compl-msg1">You are registered!</label>
		<label name="form__compl-msg2">Please check your email.</label>
	</form>
</div>
<!--site-footer-->
<footer>
	<div>Copyright © 2013 | bazinger | All Rights Reserved</div>
	<div><a href="#">Terms of Service</a> | <a href="#">Privacy Policy</a></div>	
</footer>
<!--всплывающая форма по клику на "download"-->
<div class="hidden">
<!--"form__dwn-el" нужен, чтобы схлопывались только элементы формы а не навешанный интерфейс-->
	<form name="form__dwn" method="post" action="./assets/php/ajaxDwne.php">
		<label class = "form__dwn-el" name="form__name">Product key</label>
		<input class = "form__dwn-el" type="text" name="name" placeholder="Your name">
		<input class = "form__dwn-el" type="text" name="password" placeholder="Your password">
		<input class = "form__dwn-el" type="text" name="tel" placeholder="Your telephon number">
		<label class = "form__dwn-el" name="tel__err-msg">Укажите телефон</label>
		<button class = "form__dwn-el" type="submit" name="button">Get</button>
		<label name="form__compl-msg1">Thanks!</label>
		<label name="form__compl-msg2">Message sent to your number.</label>
	</form>
	<div class="preload">
		<img src="./assets/img/preload.gif">
		<div class="load_msg">Loading...</div>
	</div>
</div>
<div class="preload">
	<img src="./assets/img/preload.gif">
	<div class="load_msg">Loading...</div>
</div>
<script src="./assets/js/jquery-3.0.0.min.js"></script>
<script src="./assets/js/slick/slick.min.js"></script>
<script src="./assets/js/fancybox/dist/jquery.fancybox.js"></script>
<script src="./assets/js/jquery.magnific-popup.min.js"></script>
<script src="./assets/js/jquery.maskedinput.min.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?apikey=87c66f3f-504e-4a60-a5de-383af6cf73cd&lang=ru_RU" type="text/javascript"></script>
<script src="./assets/js/script.js"></script>
</body>
</html>