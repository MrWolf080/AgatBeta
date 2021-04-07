<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?>
<link rel="stylesheet" href="../styles/style_addservice.css" type="text/css">
<title>Добавление услуги</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a href="/index.php" class="header__logo">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="../index.php#about__us">О нас</a>
                        <a class="nav__link" href="/employers.php">Сотрудники</a>
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
                    </nav>
                    <!--<button id="login" class="button">Вход / Регистрация</button>-->
                </div>
            </div>
        </header>
        <div class="message">
<?php
    if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
    {
        echo 'У вас нет прав для работы с этой страницей<br>';
        exit;
    }
            if($_SESSION['message'])
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
        ?>
</div>
<form action="../lk/vendor/addservice.php" method="post">
    <h1>Добавление услуги</h1>
    <div class="haveacc">
        <label>Название</label>
        <input type="text" name="name" placeholder="Введите название">
         <br>
        <label>Описание</label>
        <input type="text" name="descr" placeholder="Введите описание">
         <br>
        <label>Цена</label>
        <input type="text" name="price" placeholder="Введите цену">
         <br>
        <label>Средняя длительность</label>
        <input type="text" name="cont" placeholder="Введите среднюю продолжительность в минутах">
         <br> <div class="check__list">
         <?php
            $q=mysqli_query($connect, "SELECT `id`, `fio` FROM `empl`");
            if(mysqli_num_rows($q)>0)
            {
                echo '<label>Сотрудники, выполняющие эту услугу</label><br>';
                while($empl=mysqli_fetch_assoc($q))
                {
                    $id=$empl['id'];
                    $fio=$empl['fio'];
                    echo '<input type="checkbox" name="'.$id.'">'.$fio.'<br>';
                }
        ?> </div> <?
            }
         ?>
         <div class="butt">
        <button type="submit">Добавить</button>
    </div>
    </div>
</form>
<?php
    mysqli_close($connect);
?>
