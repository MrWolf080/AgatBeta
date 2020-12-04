<?php
	session_start();
?>
<form action="vendor/signin.php" method="post">
	<label>ФИО или email</label>
	<input type="text" name="fio" placeholder="Введите свой логин">
	<label>Пароль</label>
	<input type="password" name="password" placeholder="Введите пароль">
	<button type="submit">Войти</button>
	<p>
		У вас нет аккаунта? - <a href="../lk/reg.php">Зарегистрируйтесь</a>
	</p>
	<?php
		if($_SESSION['message'])
		{
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	?>
</form>