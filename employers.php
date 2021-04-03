<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
        <meta charset="UTF-8">
        <title>Сотрудники</title>
        <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <style>
            body{
                background-color: mediumslateblue;
                font-family: 'Tenor Sans';
                font-size: 20px;
            }
            /* HEADER */

.container {
    width: 100%;
    max-width: 1200px;
    max-height: 250px;
    margin: auto;
}

.header {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    padding-top: 10px;
}

.header__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header__logo {
    font-size: 70px;
    font-weight: 700;
    font-family: 'Italianno';
    color: #fff;
    z-index: 0;
    text-decoration: none;
}

.header__logo:hover {
    color: hsl(10, 66%, 77%);
    text-decoration-style: solid;
}


/* links / navigation */

.nav {
    font-size: 14px;
    text-transform: uppercase;
}

.nav a {
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
    font-size: 14px;
    color: #fff;
}

.nav__link {
    display: inline-block;
    vertical-align: top;
    margin: 0 15px;
    color: #fff;
    text-decoration: none;
    transition: color 0.25s linear;
    position: relative;
}

.nav__link:after {
    content: "";
    display: block;
    width: 100%;
    height: 2px;
    background-color: hsl(10, 66%, 77%);
    opacity: 0;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1;
    transition: opacity 0.25s linear;
}

.nav__link:hover {
    color: hsl(10, 66%, 77%);
}

.nav__link:hover:after {
    opacity: 1;
}
            .employers__content{
                max-width: 1200px;
                margin-top: 100px;
            }
         </style>
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
   <?php
    require_once 'lk\vendor\db_connection.php';

    $count_empl=mysqli_query($connect, "SELECT COUNT(*) FROM `empl`");
    if(mysqli_fetch_array($count_empl)[0]==0)
        echo "Сотрудников пока нет.<br>";

    if($_SESSION['message'])
    {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

    $query=mysqli_query($connect, "SELECT * FROM `empl`");


    while( $arr = mysqli_fetch_assoc( $query ) )
    {
        ?>
        <div class="employers__content">
        <div class="1"><img height="300px" src="data:image/*;base64,<? echo base64_encode($arr['photo']); ?>" /><br></div>

        <div class="2"><? echo $arr['fio']; ?></div>
        <div class="3"><? echo $arr['email']; ?></div>
        <div class="4"><? echo $arr['descr']; ?></div>
        <?
        $id_empl=$arr['id'];
        $query2=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_empl`='$id_empl'");
        if(mysqli_num_rows($query2)>0)
        {
        ?>

        <div class="5">Услуги, выполняемые сотрудником:</div>
            <?
            while($ids=mysqli_fetch_assoc($query2))
            {
                $id_serv=$ids['id_serv'];
                $name=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_serv'"))['name'];
                ?>
            <div class="6"><? echo $name; ?></div>
                <?
            }

        }
        ?>
        </div>
        <?

    }

    if($_SESSION['user'])
            if($_SESSION['user']['role']==3)
            {
                echo '<a href="admin/addempl.php">Добавить сотрудника</a><br>';
                echo '<a href="admin/editempl.php">Редактировать сотрудника</a><br>';
            }
    mysqli_close($connect);
?>
