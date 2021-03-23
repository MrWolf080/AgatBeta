<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Beauty studio Agat</title>
  <link href="../styles/style.css" type="text/css" rel="stylesheet">
  <p align="center"> <font color="red"> 
  <?php
	if($_SESSION['message'])
		{
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
   ?>
   </font>
   </p>
</head>
<header>
</header>
<body>

	<h1>
	<font>Добро пожаловать в Beauty Studio AgaT</font>
	</p>
	
	<p align="right">
	   <?php
		if($_SESSION['user'])
		{
			echo 'Привет, '.$_SESSION['user']['fio']. ' <a href="lk/exit.php">Выход</a>';
		}
		else
		{
			echo '<a href="lk/auth.php">Вход/Регистрация</a>';
		}
	  ?>
	</h1>
   
   
</body>
</html>