<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/style_addservice.css" type="text/css">
<link rel="stylesheet" href="/styles/style_header_footer.css" type="text/css">
<title>Добавление услуги</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

</head>
<body>
<style type="text/css">
            #hellopreloader_preload {
                display: block;
                position: fixed;
                z-index: 99999;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: #333 url(http://hello-site.ru//main/images/preloads/oval.svg) center center no-repeat;
                background-size: 118px;
                margin: 0 auto;
            }


        </style>
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
<header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a href="/index.php" class="header__logo">AgaT</a>
                    <nav class="nav" id="nav">
                       <div class="cov" id="cov">
                        <a class="nav__link" href="../index.php#about__us">О нас</a>
                        <a class="nav__link" href="../employers.php">Сотрудники</a>
                        <a class="nav__link" href="../records.php">Записаться</a>
                        <a class="nav__link" href="../services.php">Услуги и цены</a>
                        <a class="nav__link" href="../index.php#footer">Контакты</a>
                        <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php
                            if(!$_SESSION['user'])
                            {
                        ?>
                        <a id="login" class="button blue" href="../lk/auth.php">
                            <i class="fa fa-unlock"></i>
                            <span>Войти</span>
                        </a>
                        <a id="register" class="button purple" href="../lk/reg.php">
                            <i class="fa fa-user-plus"></i>
                            <span>Зарегистрироваться</span>
                        </a>
                        <?php
                            }
                            else
                            {
                            ?>
                                <a id="login" class="button purple" href="../lk/exit.php">
                                    <i class="fa fa-unlock"></i>
                                     <span>Выйти</span>
                                </a>
                            <?php
                            }
                        ?>
                        </div>
                    </nav>
                    <button class="nav-toggle" id="nav_toggle" type="button">
                        <span class="nav-toggle__item">menu</span>
                    </button>
                </div>
            </div>
        </header>
<form action="../lk/vendor/addservice.php" method="post">
<div class="admin__buttons">
    <?php
        if($_SESSION['user'])
        {
                if($_SESSION['user']['role']==3)
                {
                    ?>
                    <a href="editservice.php" class="button purple adm">Редактировать услугу</a>
                    <?
                }
        }
    ?>
    <div class="message">
        <?php
            if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
            {
                ?>
                У вас нет прав для работы с этой страницей<br>
                <?
                exit;
            }
        ?>
    </div>
    <div class="message">
        <?
            if($_SESSION['message'])
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
        ?>
    </div>
</div>
    <h1>Добавление услуги</h1>
    <div class="haveacc">
        <label>Название</label>
        <br>
        <input type="text" name="name" placeholder="Введите название">
        <br>
        <label>Описание</label>
        <br>
        <input type="text" name="descr" placeholder="Введите описание">
        <br>
        <label>Цена</label>
        <br>
        <input type="text" name="price" placeholder="Введите цену">
        <br>
        <label>Средняя длительность</label>
        <br>
        <input type="text" name="cont" placeholder="Введите среднюю продолжительность в минутах">
        <br>
        <div class="check__list">
            <?php
                $q=mysqli_query($connect, "SELECT `id`, `fio` FROM `empl`");
                if(mysqli_num_rows($q)>0)
                {
                    ?>
                    <label>Сотрудники, выполняющие эту услугу</label><br>
                    <div class="checkbox_list">
                    <?
                        while($empl=mysqli_fetch_assoc($q))
                        {
                            $id=$empl['id'];
                            $fio=$empl['fio'];
                            ?>
                           <label><input type="checkbox" name="<? echo $id; ?>"><? echo $fio; ?></label><br>
                            <?
                        } ?>
                    </div>
               <?
                }
            ?>
        </div>
        <div class="butt">
            <button type="submit">Добавить</button>
        </div>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/main.js"></script>
    </body>
</html>
<?php
    mysqli_close($connect);
?>
