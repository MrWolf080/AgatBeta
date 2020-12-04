<?php
	session_start();
?>
<link rel="stylesheet" href="../styles/stylelog.css" type="text/css">
<form action="vendor/signin.php" method="post">
    <h1>Вход</h1>
	<div class="haveacc">
		<label>ФИО или email</label>
		<br>
		<input type="text" name="fio" placeholder="Введите свой логин">
		<br>
		<label>Пароль</label>
		<br>
		<input type="password" name="password" placeholder="Введите пароль">
		<br>
		<button type="submit">Войти</button>
		<p>
			У вас нет аккаунта? - <a href="../lk/reg.php">Зарегистрируйтесь</a>
		</p>
	</div>
	<div class="message">
		<?php
			if($_SESSION['message'])
			{
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
		?>
	</div>
</form>