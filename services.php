<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Услуги и цены</title>
    <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style_services.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
</head>
<body>
   <div class="body__bgr">
    <header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a href="/index.php" class="header__logo">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="/index.php#about__us">О нас</a>
                        <a class="nav__link" href="employers.php">Сотрудники</a>
                        <a class="nav__link" href="/records.php"
                        >Записаться</a>
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
                        <a id="register" class="button purple" href="/lk/reg.php">
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
<div class="change_delete">
<?
    if($_SESSION['user'])
            if($_SESSION['user']['role']==3)
            {
                echo '<a href="admin/addservice.php" style="color: white;font-family: helvetica;text-decoration: none;text-transform: uppercase; margin-top:20%; font-size: 30px;">Добавить услугу</a><br>';
                echo '<a href="admin/editservice.php" style="color: white;font-family: helvetica;text-decoration: none;text-transform: uppercase; margin-top:20%; font-size: 30px;">Редактировать услугу</a><br>';
            }
?> </div>
<div class="message">
<?
    if($_SESSION['message'])
    {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }

?></div>
<?php
    require_once 'lk/vendor/db_connection.php';
    $count_serv_q=mysqli_query($connect, "SELECT COUNT(*) FROM `service`");
?>
<?
    $count_serv=mysqli_fetch_array($count_serv_q)[0];
    if($count_serv==0)
        echo '<div align="center" class="mess">Услуг пока нет.<br></div>';
?>
<?
    $query=mysqli_query($connect, "SELECT * FROM `service`");
    $numcols=1;
    if($count_serv!=0)
    {
?>

    <div class="services__logo">Услуги и цены</div>
    <div class="services__table">
    <table>
    <colgroup>
        <col span="3" style="width:350px; background-color: hsla(10, 66%, 77%, .4);">
      </colgroup>
<?
    while( $arr = mysqli_fetch_assoc( $query ) )
    {
        if($numcols==1)
            echo '<tr>';
        ?>
        <td><div class="services__content">
        <div class="serv1"><? echo $arr['name']; ?></div>
        <div class="serv3"><? echo $arr['price']; ?> руб.</div>
        <div class="serv2"><? echo $arr['descr']; ?></div>
        <?
        if($_SESSION['user'])
            if($_SESSION['user']['role']>1){ ?>
                <div class="serv4">Длительность: <? echo $arr['cont'].'мин.'; }?> </div>
        <?
        $id_serve=$arr['id'];
        $query2=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_serv`='$id_serve'");
        if(mysqli_num_rows($query2)>0)
        {
            ?>
            <div class="serv5">Сотрудники, выполняющие услугу:</div>
            <?
            while($ids=mysqli_fetch_assoc($query2))
            {
                $id_empl=$ids['id_empl'];
                $fio=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `fio` FROM `empl` WHERE `id`='$id_empl'"))['fio'];
                ?>
                <div class="serv6"><? echo $fio; ?></div>
                <?
            }
        }
        ?>
            </div></td>
        <?
        if($numcols==3)
        {
            echo '</tr>';
            $numcols=0;
        }
        $numcols++;
    }
    if($numcols!=1)
        echo '</tr>';
    ?>
    </table></div>
    <?
    }
mysqli_close($connect);
?>
</div>
<div class="footer" id="footer">
            <div>
                <div class="footer__inner">
                   <table><tr>
                       <td><a class="footer__logo" href="#header">AgaT</a></td>
                    <td><div class="footer__text">
                        Каждая женщина уникальна и индивидуальна.<br>А наши специалисты помогут вам ухаживать за вашей природной красотой.
                    </div></td>
                    <td><div class="footer__text">
                        Подписывайтесь на наш инстаграм:
                    </div><a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank" >
                            <i class="fab fa-instagram"></i>
                    </a></td>
                       <td><div class="footer__phone" align="right">+7(908)517-73-00</div><div class="footer__adress" align="right">Ростов-на-Дону ул. Пулковская 36</div></td>
                       </tr></table>
                </div>
            </div>

</div>
</body>
</html>
