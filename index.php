<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Beauty studio Agat</title>
  <link href="https://fonts.googleapis.com/css?family=Lato: 100,300,400,700|Luckiest+Guy|Oxygen:300,400" rel="stylesheet">
  <link href="../styles/style.css" type="text/css" rel="stylesheet">
  <h1>
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
   </h1>
</head>
<body>

	<h1>
	<p align="left"><big><big>Добро пожаловать в Beauty Studio AgaT</big></big></p>
	</p>
	<?php
	if($_SESSION['user'])
		if($_SESSION['user']['role']==3)
		{
			echo '<a href="settings.php">Настройки сайта</a>';
		}
		?>
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
   
   <h2>Мы рады,что вы выбрали именно нас</h2>
   
</body>
	<table>
        <thead>
            <tr>
                <th scope="col">Информация</th>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th scope="col"><a href="employers.php">Сотрудники</a></th>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th scope="col"><a href="services.php">Услуги</a></th>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th scope="col"><a href="records.php">Запись</a></th>
            </tr>
        </thead>
    </table>
	<table>
        <thead>
            <tr>
                <th scope="col">Контакты</th>
            </tr>
        </thead>
    </table>
</html>