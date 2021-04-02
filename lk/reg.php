<?php
    session_start();
?>
<link rel="stylesheet" href="../styles/stylelog.css" type="text/css">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<title>Регистрация</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
<header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a class="header__logo" href="../index.php">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="#">О нас</a>
                        <a class="nav__link" href="#">Сотрудники</a>
                        <a class="nav__link" href="#">Галерея</a>
                        <a class="nav__link" href="#">Услуги и цены</a>
                        <a class="nav__link" href="#">Контакты</a>
                        <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </header>
		
    <div class="message">
        <?php
            if($_SESSION['good_message'])
            {
                echo $_SESSION['good_message'];
                unset($_SESSION['good_message']);
            }
        ?>
		<?php
			if($_SESSION['user'])
            {
                echo 'Вы уже авторизованы';
				exit;
            }
		?>
		<?php
            if($_SESSION['bad_message'])
            {
                echo $_SESSION['bad_message'];
                unset($_SESSION['bad_message']);
            }
        ?>
    </div>
<form action="" method="post">
    <div class="form">
    <div class="label_auth_reg">Регистрация</div>
        <div class="haveacc">
            <div align="right">
                <label>ФИО <i>(полностью)</i>:</label>
                <input type="text" name="fio" placeholder="Введите свое полное имя" value="<?php if($_POST['fio']) echo $_POST['fio']; ?>">
                <br>
                <label>Почта:</label>
                <input type="email" name="email" placeholder="Введите свой email" value="<?php if($_POST['email']) echo $_POST['email']; ?>">
                <br>
                <label>Телефон +7-ххх-ххх-хх-хх:</label>
                <input type="text" name="tel" pattern="\+7-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" placeholder="Введите ваш номер телефона" value="<?php if($_POST['tel']) echo $_POST['tel']; ?>">
                <br>
                <label>Пароль</label>
                <input type="password" name="password" placeholder="Введите пароль">
                <br>
                <label>Подтвердите пароль:</label>
                <input type="password" name="pass_conf"placeholder="Введите пароль ещё раз">
                <br>
            </div>
            <button type="submit" name="reg"><i class="fa fa-user-plus"></i>Зарегистрироваться</button>
            <p color="">
                <b>У вас уже есть аккаунт?</b> - <a href="auth.php" class="button purple"><i class="fa fa-unlock"></i>Авторизуйтесь</a>
            </p>
        </div>
    </div>
</form>
<?php
	if(isset($_POST['reg']))
	{
		require_once 'vendor/db_connection.php';
	
		$fio=antisql($connect, $_POST['fio']);
		$email=antisql($connect, $_POST['email']);
		$tel=antisql($connect, $_POST['tel']);
		$password=$_POST['password'];
		$pass_conf=$_POST['pass_conf'];
		
		
		if($fio==''||$email==''||$tel==''||$password==''||$pass_conf=='')
		{
			$_SESSION['bad_message']='Пожалуйста, заполните все поля';
			echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
			exit;
		}
		
		if($password!=$pass_conf)
		{
			$_SESSION['bad_message']='Ошибка: Пароли не совпадают!';
			echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
			exit;
		}
		
		if(mb_strlen($tel)<5||mb_strlen($tel)>18)
		{
			$_SESSION['bad_message']='Ошибка: Длина телефона должна быть в пределах 5-18 цифр';
			echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
			exit;
		}
		
		if(mb_strlen($password)<4||mb_strlen($password)>15)
		{
			$_SESSION['bad_message']='Ошибка: Длина пароля должна быть в пределах 4-15 символов';
			echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
			exit;
		}
		
		$password=md5(antisql($connect, $password));
		
		$query=mysqli_query($connect, "INSERT INTO `user` (`id`, `fio`, `email`, `tel`, `password`,`role`) VALUES (NULL, '$fio', '$email', '$tel', '$password',1)");
		
		if(!$query)
		{
			$_SESSION['bad_message']='Неизвестная ошибка';
			echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
			exit;
		}
		$_SESSION['good_message']='Регистрация прошла успешно';
		$check_user=mysqli_query($connect, "SELECT * FROM `user` WHERE (`fio`='$fio' OR `fio`='$email') AND `password`='$password' AND `email`='$email' AND `tel`='$tel'");
		$user=mysqli_fetch_assoc($check_user);
		$_SESSION['user']=
		[
			"id"=>$user['id'],
			"fio"=>$user['fio'],
			"email"=>$user['email'],
			"role"=>$user['role']
		];
		
		mysqli_close($connect);
		echo "<script>window.location.href='../index.php';window.location.replace('../index.php');</script>";
		}
?>
