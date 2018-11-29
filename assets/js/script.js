//alert('test');
//console.log('test');
$('.sl').slick({
	lazyLoad: 'progressive',
	dots: true,
	autoplay: true,
	autoplaySpeed: 3000,
	speed: 1500,
	cssEase:'ease',
	infinity: true,
	pauseOnFocus: true,
	pauseOnHover: false,
	pauseOnDotsHover: true,
	centerMode: true,
	centerPadding: '0px'
});
$(".shot-box a").fancybox({	
	loop: true,
	infobar: false, //номер фото слева сверху
	caption: function( instance, item) {
		var caption = $(this).data('caption') || '';    
		return (caption.length ? caption + '<br />' : '') + 
		'<span style="font-family: DroidSans; color: #4bcaff">\
		SCREEN SHOT #<span data-fancybox-index></span> of <span data-fancybox-count></span>\
		</span>';
	}         
});
//подсветка неправильно заполненных полей
	function inputErrStyle(imput_name, x) {
		//document.styleSheets[0].insertRule('input[name="'+imput_name+'"]::-webkit-input-placeholder {color: red; }', 0);
		if (x==0) {
			document.styleSheets[1].insertRule('input[name="'+imput_name+'"]{box-shadow: none;}', 1);
		} else {
			document.styleSheets[0].insertRule('input[name="'+imput_name+'"]{box-shadow: inset 0 -3px 3px 0 red;}', 0);
		}
	};
//валидация обязательных значений
$('form[name="form__reg"]').on('submit',sendForm);
function sendForm(e) {
	e.preventDefault();
	//console.log('нажата кнопка "Send"');
	var name = document.forms["form__reg"]["name"];
	var email = document.forms["form__reg"]["email"];
	//var subject = document.forms["form__reg"]["subject"];
	//var message = document.forms["form__reg"]["message"];
	var nameVld = emailVld = false;
	//имя
	var nameReg=/\d/; //имя не должно содержать цифр
	if (name.value.length==0) {
		//name.placeholder="Укажите имя";
		inputErrStyle("name",1);
		$('label[name="name__err-msg1"]').css('display', 'initial');
		$('label[name="name__err-msg2"]').css('display', 'none');
		$('label[name="name__err-msg3"]').css('display', 'none');
	} else if (name.value.length<2 | name.value.length>30) {
		inputErrStyle("name",1);
		//name.value="";
		//name.placeholder="Укажите имя от 2 до 30 символов";
		$('label[name="name__err-msg1"]').css('display', 'none');
		$('label[name="name__err-msg2"]').css('display', 'initial');
		$('label[name="name__err-msg3"]').css('display', 'none');
	} else if (name.value.search(nameReg)!=-1) {
		inputErrStyle("name",1);
		//name.value="";
		//name.placeholder="Имя не должно содержать цифр";
		$('label[name="name__err-msg1"]').css('display', 'none');
		$('label[name="name__err-msg2"]').css('display', 'none');
		$('label[name="name__err-msg3"]').css('display', 'initial');
		inputErrStyle("name",1);
	} else {
		$('label[name="name__err-msg1"]').css('display', 'none');
		$('label[name="name__err-msg2"]').css('display', 'none');
		$('label[name="name__err-msg3"]').css('display', 'none');
		inputErrStyle("name",0);
		nameVld = true;
	};
	//почта
	var emailReg=/\S+@\S+\.\S+/;
	//type:email->text
	//console.log(email.value.search(emailReg));
	if(email.value.length==0) {
		//email.placeholder="кажите адрес своей почты";
		$('label[name="email__err-msg1"]').css('display', 'initial');
		$('label[name="email__err-msg2"]').css('display', 'none');
		inputErrStyle("email",1);
	} else if (email.value.search(emailReg)==-1) {
		//email.value="";
		//email.placeholder="Неправильно указан адрес почты";
		$('label[name="email__err-msg1"]').css('display', 'none');
		$('label[name="email__err-msg2"]').css('display', 'initial');
		inputErrStyle("email",1);
	} else {
		$('label[name="email__err-msg1"]').css('display', 'none');
		$('label[name="email__err-msg2"]').css('display', 'none');
		inputErrStyle("email",0);
		emailVld = true;
	};
	//связь с сервером
	/*
	ajaxForm.php выдает "OK", если пришли непустые определенные данные, иначе "ERROR"
	проверка сервером входящих данных только на пустоту достаточна, 
	т.к. инвалидные данные отправиться не могут
	*/
	if (nameVld & emailVld) {
		var data = $('form[name="form__reg"]').serializeArray();
		console.dir(data);
		jQuery.ajax({
			url: "assets/php/ajaxForm.php",
			data: data,
			type: "POST",
			success: function(data){
				if (data.localeCompare("ok")==0) {
					alert("Вы зарегестрированы!\nНа почту "+email.value+" отправлено письмо");
					$('form[name="form__reg"] *').css('display', 'none');
					$('form[name="form__reg"] label[name*="form__compl-msg"]').css('display', 'initial');
				} else if (data.localeCompare("error-mail")==0) {
					alert("Не удалось отправить письмо на почту "+email.value);
				};
			}//последний параметр
		});
	};
};
//всплывающая форма по клику на "download"
$(".download a").magnificPopup();
$('input[name="tel"]').mask("+7(999) 999-9999");
$('form[name="form__dwn"]').on('submit',dwnForm);
function dwnForm(e) {
	e.preventDefault();
	var tel = document.forms["form__dwn"]["tel"];
	//console.log(tel.value.length);
	if (tel.value.length==0) {
		$('label[name="tel__err-msg"]').css('display', 'initial');
		inputErrStyle("tel",1);
	} else {
		$('label[name="tel__err-msg"]').css('display', 'none');
		inputErrStyle("tel",0);
		var data = $('form[name="form__dwn"]').serializeArray();
		console.dir(data);
		jQuery.ajax({
			url: "assets/php/ajaxDwn.php",
			data: data,
			type: "POST",
			success: function(data){
				alert(data);
				$('form[name="form__dwn"] *').css('display', 'none');
				$('form[name="form__dwn"] label[name*="form__compl-msg"]').css('display', 'initial');
			}//последний параметр
		});
	};
};
//курта
ymaps.ready(init);
function init(){ 
	// Создание карты.    
	var myMap = new ymaps.Map("map", {
		// Координаты центра: [широта, долгота]
		center: [54.21826124615793,45.19209499218749],
		// Уровень масштабирования
		zoom: 13 // от 0 (весь мир) до 19
	});
	var myPlacemark1 = new ymaps.Placemark([54.230733941706276,45.13407344677734],{
		hintContent:'Мой дом'
	});
	var myPlacemark2 = new ymaps.Placemark([54.221778161336516,45.266775058792376],{
		hintContent:'Тут что то находится'
	});
	myMap.geoObjects.add(myPlacemark1);
	myMap.geoObjects.add(myPlacemark2);
}