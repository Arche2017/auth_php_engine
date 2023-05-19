var loginBtn=document.getElementById('login_btn');
var registerBtn=document.getElementById('register_btn');
if(loginBtn){
	document.getElementById('login_btn').onclick=function(){
		let	login = document.getElementById('login').value;
		let password = document.getElementById('password').value;

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

		    if(request.readyState === 4 && request.status === 200 && request.response!="false") {
		    	let result=JSON.parse(request.response);
				document.getElementById('login_btn').remove();
				document.getElementById('reg_link').setAttribute('href','/exit');
				document.getElementById('reg_link').innerHTML='Выйти';
				document.getElementById('reg_title').innerHTML = result.name+', вы успешно вошли в систему!';
				document.getElementById('login_block').innerHTML = '<li>Имя:'+result.name+'</li><li>Логин:'+result.login+'</li>';
		    }
		    else if(request.response=="false") {
		    	alert(`Неверный логин или пароль!`);
		    }
		});
		//	Вот здесь мы и передаем строку с данными, которую формировали выше. И собственно выполняем запрос.
		request.send(params);
	}
}
if(registerBtn){
	document.getElementById('register_btn').onclick=function(){
		let	login = document.getElementById('login').value;
		let	name = document.getElementById('name').value;
		let password = document.getElementById('password').value;

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
			if(request.response=='exists') alert(`Такой логин уже зарегистрирован!`);
		    else if(request.readyState === 4 && request.status === 200 && request.response!="false") {
		    	let result=JSON.parse(request.response);
				document.getElementById('register_btn').remove();
				document.getElementById('exit_link').setAttribute('href','/exit');
				document.getElementById('exit_link').innerHTML='Выйти';
				document.getElementById('reg_title').innerHTML = result.name+', вы успешно зарегистрировались!';
				document.getElementById('registration_block').innerHTML = '<li>Имя:'+result.name+'</li><li>Логин:'+result.login+'</li>';
		    }
		    else if(request.response=="false") {
		    	alert(`Ошибка регистрации!`);
		    }
		});
		//	Вот здесь мы и передаем строку с данными, которую формировали выше. И собственно выполняем запрос.
		request.send(params);
	}
}
