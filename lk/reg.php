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
<form action="vendor/signup.php" method="post">
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
            if($_SESSION['message'])
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
        ?>
    </div>
    <div class="form">
    <div class="label_auth_reg">Регистрация</div>
        <div class="haveacc">
            <div align="right">
                <label>ФИО <i>(полностью)</i>:</label>
                <input type="text" name="fio" placeholder="Введите свое полное имя">
                <br>
                <label>Почта:</label>
                <input type="email" name="email" placeholder="Введите свой email">
                <br>
                <label>Телефон:</label>
                <input type="text" name="tel" placeholder="Введите ваш номер телефона">
                <br>
                <label>Пароль <i>(латиница):</i></label>
                <input type="password" name="password" placeholder="Введите пароль">
                <br>
                <label>Подтвердите пароль:</label>
                <input type="password" name="pass_conf"placeholder="Введите пароль ещё раз">
                <br>
            </div>
            <button type="submit"><i class="fa fa-user-plus"></i>Зарегистрироваться</button>
            <p color="">
                <b>У вас уже есть аккаунт?</b> - <a href="auth.php" class="button purple"><i class="fa fa-unlock"></i>Авторизуйтесь</a>
            </p>
        </div>
    </div>
</form>
