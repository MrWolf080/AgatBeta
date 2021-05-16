<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/style_addempl.css" type="text/css">
<link rel="stylesheet" href="/styles/style_header_footer.css" type="text/css">
<title>Добавление сотрудника</title>
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
<div class="admin__buttons">
    <?php
        if($_SESSION['user'])
        {
                if($_SESSION['user']['role']==3)
                {
                    ?>
                    <a href="editempl.php" class="button purple adm">Редактировать сотрудника</a>
                    <?
                }
        }
    ?>
</div>
<div class="not_enough">
<?php
    if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
    {
        echo 'У вас нет прав для работы с этой страницей<br>';
        exit;
    }
?>
</div>
<form action="../lk/vendor/addempl.php" method="post"  enctype="multipart/form-data">

    <div class="bad_message">
        <?php
            if($_SESSION['bad_message'])
            {
                echo $_SESSION['bad_message'];
                unset($_SESSION['bad_message']);
            }
        ?>
    </div>
    <h1 class="title_logo">Добавление сотрудника</h1>
    <div class="haveacc">
        <label>ФИО</label>
        <br>
        <input type="text" name="fio" placeholder="Введите ФИО сотрудника">
         <br>
        <label>Почта</label>
         <br>
        <input type="email" name="email" placeholder="Введите адрес почты сотрудника">
         <br>
        <label>Описание</label>
         <br>
         <textarea id="textComment" name="descr" style="padding-bottom:250px ;  font-size:16px;  height: 50px;  width: 60%;"></textarea>
        <br>
        <label>Загрузите фото 7x10</label>
         <br>
        <input type="file" name="image" />
         <br>
        <?php
            $q=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
            if(mysqli_num_rows($q)>0)
            {
                echo '<label>Услуги, выполняемые этим сотрудником</label><br>';
                ?>
                <div class="checkbox_list"> <?
                while($empl=mysqli_fetch_assoc($q))
                {
                    $id=$empl['id'];
                    $name=$empl['name'];

                    echo '<div class="check"><label><input type="checkbox" name="'.$id.'"/>'.$name.'</label></div>';

                }
            }
         ?>
        </div>
        <button type="submit">Добавить</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/main.js"></script>
    </body>
</html>

<?php
    mysqli_close($connect);
?>
