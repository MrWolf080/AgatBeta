<?php
	session_start();
?>
<link rel="stylesheet" href="../styles/stylelog.css" type="text/css">
<form action="vendor/signup.php" method="post">
    <h1>Регистрация</h1>
	<div class="haveacc">
		<label>ФИО</label>
		<br>
		<input type="text" name="fio" placeholder="Введите свое полное имя">
		 <br>
		<label>Почта</label>
		 <br>
		<input type="email" name="email" placeholder="Введите адрес своей почты">
		 <br>
		<label>Телефон</label>
		 <br>
		<input type="text" name="tel" placeholder="Введите свой телефон">
		 <br>
		<label>Пароль</label>
		 <br>
		<input type="password" name="password" placeholder="Введите пароль">
		 <br>
		<label>Подтвердите пароль</label>
		 <br>
		<input type="password" name="pass_conf"placeholder="Введите пароль">
		 <br>
		<button type="submit">Зарегистрироваться</button>
		<p>
			У вас уже есть аккаунт? - <a href="../lk/auth.php">Авторизуйтесь</a>
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