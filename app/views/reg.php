
<h2>Добро пожаловать!</h2>
<h2 id="reg_title">Страница регистрации</h2>
<a href="" id="exit_link"></a>
<form action="/reg_user" method="POST">
<ul id="registration_block" class="auth_block">
	<li>
		<label for="login">Введите логин/email</label>
		<input type="text" id="login" class="user_data" name="login" />
	</li>
	<li>
		<label for="name">Введите имя</label>
		<input type="text" id="name" class="user_data" name="name" />
	</li>
	<li>
		<label for="password1">Придумайте пароль</label>
		<input type="password" id="password" class="user_data" name="password" />
	</li>
</ul>
<button id="register_btn" class="reg_btn" type="button">Зарегистрироваться</button>
</form>

