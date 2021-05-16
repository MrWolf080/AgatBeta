<?php
    session_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Beauty studio Agat</title>
        <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/style_header_footer.css" type="text/css">
		<link rel="stylesheet" href="styles/style_preloader.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> </head>

    <body id="header">
            <div id="hellopreloader">
                <div id="hellopreloader_preload"></div>
        </div>
        <script type="text/javascript">
            var hellopreloader = document.getElementById("hellopreloader_preload");

            function fadeOutnojquery(el) {
                el.style.opacity = 1;
                var interhellopreloader = setInterval(function () {
                    el.style.opacity = el.style.opacity - 0.05;
                    if (el.style.opacity <= 0.05) {
                        clearInterval(interhellopreloader);
                        hellopreloader.style.display = "none";
                    }
                }, 16);
            }
            window.onload = function () {
                setTimeout(function () {
                    fadeOutnojquery(hellopreloader);
                }, 1000);
            };
        </script>

        <header class="header">
            <div class="container">
                <div class="header__inner"> <a href="#header" class="header__logo">AgaT</a>
                    <nav class="nav" id="nav">
                        <div class="cov" id="cov"> <a class="nav__link" href="#about__us">О нас</a> <a class="nav__link" href="employers.php">Сотрудники</a> <a class="nav__link" href="records.php">Записаться</a> <a class="nav__link" href="services.php">Услуги и цены</a> <a class="nav__link" href="#footer">Контакты</a>
                            <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank"> <i class="fab fa-instagram"></i> </a>
                            <?php
                            if(!$_SESSION['user'])
                            {
                        ?>
                                <a id="login" class="button blue" href="lk/auth.php"> <i class="fa fa-unlock"></i> <span>Войти</span> </a>
                                <a id="register" class="button purple" href="lk/reg.php"> <i class="fa fa-user-plus"></i> <span>Зарегистрироваться</span> </a>
                                <?php
                            }
                            else
                            {
                            ?>
                                    <a id="login" class="button purple" href="lk/exit.php"> <i class="fa fa-unlock"></i> <span>Выйти</span> </a>
                                    <?php
                            }
                        ?>
                        </div>
                    </nav>
                    <button class="nav-toggle" id="nav_toggle" type="button"> <span class="nav-toggle__item">menu</span> </button>
                </div>
            </div>
        </header>
        <div class="intro">
            <div class="settings">
                <? if($_SESSION['user']&&$_SESSION['user']['role']==3)
                {
                    echo '<a href="settings.php" class="button purple" style="color: white;font-family: helvetica;text-decoration: none;text-transform: uppercase;margin-top: 10px; font-size: 30px; ">Настройки</a>';
                }
                ?> </div>
            <div class="message">
                <?php
                if($_SESSION['good_message'])
                {
                    echo $_SESSION['good_message'];
                    unset($_SESSION['good_message']);
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
            <div class="container">
                <div class="intro_inner">
                    <?
                   if($_SESSION['user'])
                    {
                    ?>
                        <div class="intro__authended">
                            <h7>Здравствуйте,</h7>
                            <? echo $_SESSION['user']['fio']; } ?>
                        </div>
                        <h2 class="intro__title">
                        Добро пожаловать в
                    </h2>
                        <h1 class="intro_subtitle">
                        Beauty Studio AgaT
                    </h1>
                        <a href="records.php"><img src="/img/btn_white_text.png" alt="" width="400" class="button_grow" loading="lazy"></a>
                </div>
            </div>
        </div>
        <section id="about__us" class="section">
            <div class="container">
                <div class="section__header"> <img src="../img/about__item1.jpg" alt="" align="right" width="500" padding-left="10" class="grow" loading="lazy">
                    <h3 class="section__suptitle">Мы рады, что Вы</h3>
                    <h1 class="section__title">выбрали именно нас!</h1>
                    <div class="section__text">
                        <p> Мастера в «Beauty Studio Agat» это не только профессионалы своего дела, это прежде всего люди, тонко чувствующие красоту и природу, ориентирующиеся в последних тенденциях fashion-индустрии и способные преобразить каждого! </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section1" id="works">
            <div class="container">
                <div class="section__header">
                    <h3 class="section__suptitle">Галерея</h3>
                    <div class="section__text__galery">
                        <p>Заходите в наш инстаграм, чтобы следить за самыми новыми работами наших мастеров.</p>
                    </div>
                </div>
            </div>
            <div class="works">
                <div class="works__col">
                    <div class="works__item"> <img class="works__image" src="../img/works/1.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Макияж</div>
                            <div class="works__text">Визажисты нашего салона используют только качественную, стойкую косметику.</div>
                        </div>
                    </div>
                    <div class="works__item"> <img class="works__image" src="../img/works/2.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Причёска</div>
                            <div class="works__text">Мы выполняем работы любой сложности и с любой длиной волос.</div>
                        </div>
                    </div>
                </div>
                <div class="works__col">
                    <div class="works__item"> <img class="works__image" src="../img/works/3.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Стрижка</div>
                            <div class="works__text">Правильно подобранная стрижка способна полностью изменить человека, а мастера нашей бьюти-студии помогут вам в этом.</div>
                        </div>
                    </div>
                    <div class="works__item"> <img class="works__image" src="../img/works/4.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Наращивание</div>
                            <div class="works__text">Качественные материалы и профессионализм наших сотрудников помогут вам в обретении долгожданных длинных ногтей.</div>
                        </div>
                    </div>
                </div>
                <div class="works__col">
                    <div class="works__item"> <img class="works__image" src="../img/works/5.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Маникюр</div>
                            <div class="works__text">У нас большая цветовая палитра и огромный запас креативных идей для дизайна!</div>
                        </div>
                    </div>
                </div>
                <div class="works__col">
                    <div class="works__item"> <img class="works__image" src="../img/works/6.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Уход</div>
                            <div class="works__text">Различные виды спа-процедур и косметология доступны в нашем салоне</div>
                        </div>
                    </div>
                    <div class="works__item"> <img class="works__image" src="../img/works/7.jpg" alt="" loading="lazy">
                        <div class="works__info">
                            <div class="works__title">Окрашивание</div>
                            <div class="works__text">В нашем коллективе есть специалисты по сложным техникам окрашивания и ярким окрашиваниям</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer" id="footer">
            <div class="container">
                <div class="footer__inner">
                    <table>
                        <tr>
                            <td><a class="footer__logo" href="#header">AgaT</a></td>
                            <td>
                                <div class="footer__text"> Каждая женщина уникальна и индивидуальна.
                                    <br>А наши специалисты помогут вам ухаживать за вашей природной красотой. </div>
                            </td>
                            <td>
                                <div class="footer__text1"> Подписывайтесь на наш инстаграм: </div>
                                <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank"> <i class="fab fa-instagram"></i> </a>
                            </td>
                            <td>
                                <div class="footer__phone" align="right">+7(908)517-73-00</div>
                                <div class="footer__adress" align="right">Ростов-на-Дону ул. Пулковская 36</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>
