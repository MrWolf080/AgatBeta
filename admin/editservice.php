<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?>
<link rel="stylesheet" href="../styles/style_editservice.css" type="text/css">
<title>Редактирование услуги</title>
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
<div class="not_enough">
<?php
    if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
    {
        echo 'У вас нет прав для работы с этой страницей<br>';
        exit;
    }
?>
</div>
<div class="notempl">
<?
    $count_empl_q=mysqli_query($connect, "SELECT COUNT(*) FROM `service`");
    $count_empl=mysqli_fetch_array($count_empl_q)[0];
    if($count_empl==0)
        echo "Услуг пока нет.<br>";
?>
</div>
<div class="message">
    <?php
        if($_SESSION['message'])
        {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    ?>
</div>
<?
    if($count_empl!=0)
    {
    $query=mysqli_query($connect, "SELECT * FROM `service`");
?>
<form action="../lk/vendor/editservice.php" method="post" enctype="multipart/form-data">

    <h1>Редактирование услуги</h1>
    <div class="haveacc">
        <?php
            $n=mysqli_num_rows($query);
            for($i=1;$i<=$n;$i++)
            {
                $arr=mysqli_fetch_assoc($query);
                $id=$arr['id'];
                $name=$arr['name'];
                $price=$arr['price'];
                $descr=$arr['descr'];
                $cont=$arr['cont'];
                echo 'ФИО:<input type="text" value="'.$name.'" name="name'.$i.'"><br>';
                echo '<input type="hidden" name='.$i.' value='.$id.'>';
                echo 'Описание:<input type="text" value="'.$descr.'" name="descr'.$i.'"><br>';
                echo 'Цена:<input type="text" value="'.$price.'" name="price'.$i.'"><br>';
                echo 'Среднея длительность:<input type="text" value="'.$cont.'" name="cont'.$i.'"><br>';
                ?> <div class="check__list"> Выберите мастеров, которые выполняют данную услугу: <?
                $query2=mysqli_query($connect, "SELECT `id`, `fio` FROM `empl`");
                if(mysqli_num_rows($query2)>0)
                {
                    while($empl_arr=mysqli_fetch_assoc($query2))
                    {
                        $id_empl=$empl_arr['id'];
                        $fio=$empl_arr['fio'];
                        $query1=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_serv`='$id' AND `id_empl`='$id_empl'");
                        if(mysqli_num_rows($query1)>0)
                        {
                            echo '<input type="checkbox" name="'.$id.'+'.$id_empl.'" checked>'.$fio.'<br>';
                        }
                        else
                            echo '<input type="checkbox" name="'.$id.'+'.$id_empl.'" >'.$fio.'<br>';
                    }
                } ?> </div> <div class="butt"> <?
                echo '<button type="submit" name="chang'.$i.'">Изменить</button>';
                echo '<button type="submit" name="del'.$i.'">Удалить</button><br><br>'; ?> </div> <?
            }
    }
        ?>
    </div>

</form>
<?php
    mysqli_close($connect);
?>
