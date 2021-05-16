<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Сотрудники</title>
    <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style_employers.css" type="text/css">
    <link rel="stylesheet" href="/styles/style_header_footer.css" type="text/css">
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
    <div class="body__bgr">
       <header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a href="/index.php" class="header__logo">AgaT</a>
                    <nav class="nav" id="nav">
                       <div class="cov" id="cov">
                        <a class="nav__link" href="../index.php#about__us">О нас</a>
                        <a class="nav__link" href="employers.php">Сотрудники</a>
                        <a class="nav__link" href="/records.php">Записаться</a>
                        <a class="nav__link" href="/services.php">Услуги и цены</a>
                        <a class="nav__link" href="#footer">Контакты</a>
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
                        </div>
                    </nav>
                    <button class="nav-toggle" id="nav_toggle" type="button">
                        <span class="nav-toggle__item">menu</span>
                    </button>
                </div>
            </div>
        </header>
<div class="change_delete">
<?
    if($_SESSION['user'])
            if($_SESSION['user']['role']==3)
            {
                echo '<a href="admin/addempl.php" class="button purple adm">Добавить сотрудника</a><br>';
                echo '<a href="admin/editempl.php" class="button purple adm">Редактировать сотрудника</a><br>';
            }
?></div>
<div class="bad_message">
    <?
        if($_SESSION['bad_message'])
        {
            echo $_SESSION['bad_message'];
            unset($_SESSION['bad_message']);
        }

    ?>
</div>
<div class="good_message">
<?
        if($_SESSION['good_message'])
        {
            echo $_SESSION['good_message'];
            unset($_SESSION['good_message']);
        }
?>
</div>
<?php
    require_once 'lk/vendor/db_connection.php';
    $count_empl_q=mysqli_query($connect, "SELECT COUNT(*) FROM `empl`");
    $count_empl=mysqli_fetch_array($count_empl_q)[0];
    if($count_empl==0)
        echo '<div align="center" class="mess">Сотрудников пока нет.<br></div>';
?>
<?
    $query=mysqli_query($connect, "SELECT * FROM `empl`");


        ?>
        <div class="employers__logo">Наша команда</div>


        <?
        while( $arr = mysqli_fetch_assoc( $query ) )
        {

            ?>

            <td><div class="employers__content">
            <img src="data:image/*;base64,<? echo base64_encode($arr['photo']); ?>" alt="" align="right" class="grow person" height="600px" width="420px" loading="lazy"/><br>
            <div class="cover">
            <div class="personal__card">
            <div class="employers__fio"><? echo $arr['fio']; ?></div>
            <div class="employers__email"><? echo $arr['email']; ?></div>
            <div class="employers__descr"><? echo $arr['descr']; ?></div>
            <?
            $id_empl=$arr['id'];
            $query2=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_empl`='$id_empl'");
            if(mysqli_num_rows($query2)>0)
            {
            ?>

            <div class="employers__ordlist">Услуги, выполняемые сотрудником:</div>
              <div class="empl_list">
               <ul>
                <?
                while($ids=mysqli_fetch_assoc($query2))
                {
                    $id_serv=$ids['id_serv'];
                    $name=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_serv'"))['name'];
                    ?>
                   <li align="left"><? echo $name; ?></li>
                    <?
                }
                ?>
                </ul>
                 </div>
                <?
            }
            ?>

                </div></div> </div></td>




        <?
    }
    mysqli_close($connect);
?>
    </div>
 <footer class="footer" id="footer">
            <div class="container">
                <div class="footer__inner">
                   <table><tr>
                       <td><a class="footer__logo" href="/index.php">AgaT</a></td>
                    <td><div class="footer__text">
                        Каждая женщина уникальна и индивидуальна.<br>А наши специалисты помогут вам ухаживать за вашей природной красотой.
                    </div></td>
                    <td><div class="footer__text1">
                        Подписывайтесь на наш инстаграм:
                    </div><a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank" >
                            <i class="fab fa-instagram"></i>
                    </a></td>
                       <td><div class="footer__phone" align="right">+7(908)517-73-00</div><div class="footer__adress" align="right">Ростов-на-Дону ул. Пулковская 36</div></td>
                       </tr></table>
                </div>
            </div>

        </footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/main.js"></script>
    </body>
</html>
