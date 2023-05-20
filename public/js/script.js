var loginBtn=document.getElementById('login_btn');
var registerBtn=document.getElementById('register_btn');
if(loginBtn){
	document.getElementById('login_btn').onclick=function(){
		let	login = document.getElementById('login').value;
		let password = document.getElementById('password').value;
		//проверяем поля на пустоту
		if (login!=''&&password!='') {
			// Создаем экземпляр класса XMLHttpRequest
			const request = new XMLHttpRequest();
			// Указываем путь до файла на сервере, который будет обрабатывать наш запрос
			const url = "login";

			// Так же как и в GET составляем строку с данными, но уже без пути к файлу
			const params = "login=" + login+ "&password=" + password;

			/* Указываем что соединение	у нас будет POST, говорим что путь к файлу в переменной url, и что запрос у нас
			асинхронный, по умолчанию так и есть не стоит его указывать, еще есть 4-й параметр пароль авторизации, но этот
				параметр тоже необязателен.*/
			request.open("POST", url, true);
			//В заголовке говорим что тип передаваемых данных закодирован.
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.addEventListener("readystatechange", () => {
				//если сервер не передал ошибок
			    if(request.readyState === 4 && request.status === 200 && request.response!="false" && request.response!="bot") {
			    	let result=JSON.parse(request.response);
			    	//выводим данные пользователя
					document.getElementById('login_btn').remove();
					document.getElementById('reg_link').setAttribute('href','/exit');
					document.getElementById('reg_link').innerHTML='Выйти';
					document.getElementById('reg_title').innerHTML = result.name+', вы успешно вошли в систему!';
					document.getElementById('login_block').innerHTML = '<li>Имя:'+result.name+'</li><li>Логин:'+result.login+'</li>';
			    }
			    //если сервер передал false, выводим сообщение об ошибке
			    else if(request.response=="false") {
			  		console.log(request.response);
			    	alert(request.response);

			    }
			    //если сервер передал bot, выводим сообщение, что слишком много попыток и подгружаем ссылку для регистрации  и скрываем остальное
			    else if(request.response=="bot") {
			    	document.getElementById('login_btn').remove();
					document.getElementById('reg_link').setAttribute('href','/registerForm');
					document.getElementById('reg_link').innerHTML='Регистрация';
					document.getElementById('login_block').innerHTML='';
			    	alert('Слишком много попыток!');
			    }
			});
			//	Вот здесь мы и передаем строку с данными, которую формировали выше. И собственно выполняем запрос.
			request.send(params);
		}
		else alert('Введите логин и пароль!');
	}
}
if(registerBtn){
	document.getElementById('register_btn').onclick=function(){
		let	login = document.getElementById('login').value;
		let	name = document.getElementById('name').value;
		let password = document.getElementById('password').value;
		if (login!=''&&name!=''&&password!='') {
			// Создаем экземпляр класса XMLHttpRequest
			const request = new XMLHttpRequest();

			// Указываем путь до файла на сервере, который будет обрабатывать наш запрос
			const url = "register";

			// Так же как и в GET составляем строку с данными, но уже без пути к файлу
			const params = "name="+ name +"&login=" + login + "&password=" + password;

			/* Указываем что соединение	у нас будет POST, говорим что путь к файлу в переменной url, и что запрос у нас
			асинхронный, по умолчанию так и есть не стоит его указывать, еще есть 4-й параметр пароль авторизации, но этот
				параметр тоже необязателен.*/
			request.open("POST", url, true);

			//В заголовке говорим что тип передаваемых данных закодирован.
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.addEventListener("readystatechange", () => {
				//если сервер не передал ошибок
				if(request.response=='exists') alert(`Такой логин уже зарегистрирован!`);
			    else if(request.readyState === 4 && request.status === 200 && request.response!="false") {
			    	let result=JSON.parse(request.response);
			    	//выводим данные пользователя
					document.getElementById('register_btn').remove();
					document.getElementById('exit_link').setAttribute('href','/exit');
					document.getElementById('exit_link').innerHTML='Выйти';
					document.getElementById('reg_title').innerHTML = result.name+', вы успешно зарегистрировались!';
					document.getElementById('registration_block').innerHTML = '<li>Имя:'+result.name+'</li><li>Логин:'+result.login+'</li>';
			    }
			    //если сервер передал false, выводим сообщение об ошибке
			    else if(request.response=="false") {
			    	alert('Ошибка регистрации!');
			    }
			});
			//	Вот здесь мы и передаем строку с данными, которую формировали выше. И собственно выполняем запрос.
			request.send(params);
		}
		else alert('Введите данные!');
	}
}
