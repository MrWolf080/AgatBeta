<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Beauty studio Agat</title>
        <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    </head>
    <body>
        <header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a href="index.php" class="header__logo">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="#">О нас</a>
                        <a class="nav__link" href="employers.php">Сотрудники</a>
                        <a class="nav__link" href="#">Галерея</a>
                        <a class="nav__link" href="/services.php">Услуги и цены</a>
                        <a class="nav__link" href="#">Контакты</a>
                        <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php
                            if(!$_SESSION['user'])
                            {
                        ?>
                        <a id="login" class="button blue" href="lk/auth.php">
                            <i class="fa fa-unlock"></i>
                            <span>Войти</span>
                        </a>
                        <a id="register" class="button purple" href="lk/reg.php">
                            <i class="fa fa-user-plus"></i>
                            <span>Зарегистрироваться</span>
                        </a>
                        <?php
                            }
                            else
                            {
                            ?>
                                <a id="login" class="button purple" href="lk/exit.php">
                                    <i class="fa fa-unlock"></i>
                                     <span>Выйти</span>
                                </a>
                            <?php
                            }
                        ?>
                    </nav>
                    <!--<button id="login" class="button">Вход / Регистрация</button>-->
                </div>
            </div>
        </header>

        <script src="js/main.js"></script>
        <div class="intro">
         <?php
            if($_SESSION['good_message'])
            {
                echo $_SESSION['good_message'];
                unset($_SESSION['good_message']);
            }
            ?>
            <div class="container">
                <div class="intro_inner">
                  <?
                   if($_SESSION['user'])
                    {
                    ?>
                    <div class="intro__authended">
                        <h7>Здравствуйте,</h7> <? echo $_SESSION['user']['fio']; } ?>
                    </div>
                    <h2 class="intro__title">
                        Добро пожаловать в
                    </h2>
                    <h1 class="intro_subtitle">
                        Beauty Studio AgaT
                    </h1>
                    <a href="records.php"><img src="/img/btn_white_text.png" alt="" width="400" class="button_grow"></a>
                </div>
            </div>
        </div>

        <section id="about__us" class="section">
            <div class="container">
                <div class="section__header">
                    <img src="../img/about__item1.jpg" alt="" align="right" width="500" padding-left="10" class="grow">
                    <h3 class="section__suptitle">Мы рады, что Вы</h3>
                    <h1 class="section__title">выбрали именно нас!</h1>
                    <div class="section__text">
                        <p>
                            В нашей уютной студии работают только самые лучшие специальсты. Доверяя вашу красоту профессионалам Бьюти Студии AgaT, вы останетесь довольны!
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer" id="footer">
            <div class="container">
                <div class="footer__inner">
                    <a class="footer__logo" href="http://agat.ru/">AgaT</a>
                    <div class="footer__text">
                        Каждая женщина уникальна и индивидуальна. А наши специалисты помогут вам ухаживать за вашей природной красотой.
                    </div>
                </div>
            </div>
            <div class="footer__social-content">
                <div class="footer__text">Подписывайтесь на нас:</div>
                <a href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </footer>

    </body>
</html>