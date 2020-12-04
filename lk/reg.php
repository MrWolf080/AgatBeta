<?php
	session_start();
?>

<form action="vendor/signup.php" method="post">
	<label>ФИО</label>
	<input type="text" name="fio" placeholder="Введите свое полное имя">
	<label>Почта</label>
	<input type="email" name="email" placeholder="Введите адрес своей почты">
	<label>Телефон</label>
	<input type="text" name="tel" placeholder="Введите свой телефон">
	<label>Пароль</label>
	<input type="password" name="password" placeholder="Введите пароль">
	<label>Подтвердите пароль</label>
	<input type="password" name="pass_conf"placeholder="Введите пароль">
	<button type="submit">Зарегистрироваться</button>
	<p>
		У вас уже есть аккаунт? - <a href="/auth.php">Авторизуйтесь</a>
	</p>
	<?php
		if($_SESSION['message'])
		{
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	?>
</form>