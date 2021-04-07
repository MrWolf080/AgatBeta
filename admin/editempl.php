<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?>
<title>Редактирование сотрудника</title>
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
    <div class="admin__buttons">
    <?php

    if($_SESSION['user'])
            if($_SESSION['user']['role']==3)
                echo '<a href="addempl.php" style="color: white;font-family: helvetica;text-decoration: none;text-transform: uppercase; margin-top:20%;">Добавить сотрудника</a>';
        ?> </div>
<link rel="stylesheet" href="../styles/style_editempl.css" type="text/css">
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
    $count_empl_q=mysqli_query($connect, "SELECT COUNT(*) FROM `empl`");
    $count_empl=mysqli_fetch_array($count_empl_q)[0];
    if($count_empl==0)
        echo "Сотрудников пока нет.<br>";
?>
</div>
<div class="bad_message">
    <?php
        if($_SESSION['bad_message'])
        {
            echo $_SESSION['bad_message'];
            unset($_SESSION['bad_message']);
        }
    ?>
</div>
<?
    if($count_empl!=0)
    {
    $query=mysqli_query($connect, "SELECT * FROM `empl`");
?>
<form action="../lk/vendor/editempl.php" method="post" enctype="multipart/form-data">
    <h1>Редактирование сотрудника</h1>
    <div class="haveacc">
        <?php
            $n=mysqli_num_rows($query);
            for($i=1;$i<=$n;$i++)
            {
                $arr=mysqli_fetch_assoc($query);
                $id=$arr['id'];
                $fio=$arr['fio'];
                $email=$arr['email'];
                $descr=$arr['descr'];
                echo '<input type="file" name="image'.$i.'" /><br>';
                echo '<img src="data:image/*;base64,'.base64_encode($arr['photo']).'" height="400" width="280" /><br>';
                echo 'ФИО';
                echo '<input type="text" value="'.$fio.'" name="fio'.$i.'"><br>';
                echo '<input type="hidden" name='.$i.' value='.$id.'>';
                echo 'Почта';
                echo '<input type="text" value="'.$email.'" name="email'.$i.'"><br>';
                echo 'Описание';
                echo '<input type="text" value="'.$descr.'" name="descr'.$i.'"><br>';
                echo 'Список услуг, которые сотрудник осуществляет:<br>';
                ?> <div class="checkbox_list"> <?
                $query2=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
                if(mysqli_num_rows($query2)>0)
                {
                    while($serv_arr=mysqli_fetch_assoc($query2))
                    {
                        $id_serv=$serv_arr['id'];
                        $name=$serv_arr['name'];
                        $query1=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_empl`='$id' AND `id_serv`='$id_serv'");
                        if(mysqli_num_rows($query1)>0)
                        {
                            echo '<input type="checkbox" name="'.$id.'+'.$id_serv.'" checked>'.$name.'<br>';
                        }
                        else
                            echo '<input type="checkbox" name="'.$id.'+'.$id_serv.'" >'.$name.'<br>';
                    }
                } ?> </div> <?
                echo '<button type="submit" name="chang'.$i.'">Изменить</button>';
                echo '<button type="submit" name="del'.$i.'">Удалить</button><br><br>';
            }
    }
        ?>

    </div>
</form>

<?
    mysqli_close($connect);
?>
