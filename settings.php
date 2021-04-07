<?php
    session_start();
    require_once 'lk/vendor/db_connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="stylesheet" type="text/css" href="../styles/header.css" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<title>Настройки сайта</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
</head>
<body>
<header class = "header">
    <div class="container">
        <div class="header__inner">
            <a href="../
            " class="header__logo">AgaT</a>
            <nav class="nav">
                <a class="nav__link" href="index.php#about__us">О нас</a>
                <a class="nav__link" href="employers.php">Сотрудники</a>
                <a class="nav__link" href="records.php">Записаться</a>
                <a class="nav__link" href="services.php">Услуги и цены</a>
                <a class="nav__link" href="index.php#footer">Контакты</a>
                <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <?
                    if($_SESSION['user'])
                    {
                    ?>
                        <a id="login" class="button_purple" href="lk/exit.php">
                            <i class="fa fa-unlock"></i>
                             <span>Выйти</span>
                        </a>
                    <?php
                    }
                ?>
            </nav>
        </div>
    </div>
</header>
<div class="set_cont">
<div class="good_message">
<?php
    if($_SESSION['good_message'])
    {
        echo $_SESSION['good_message'];
        unset($_SESSION['good_message']);
    }
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
<div class="not_enough">
  <?
    if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
    {
        echo 'У вас нет прав для работы с этой страницей<br>';
        exit;
    }
?>
</div>
<div class="set">
    <div class="lab">Настройки сайта:</div><br>
<form action="lk/vendor/settings.php" method="post">
    <?php
        $set=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `settings`"));
        $begin=substr($set['begin'],0,5);
        $end=substr($set['end'],0,5);
        $space=$set['space'];
        echo 'Время работы: ';
        echo '<input type="time" name="begin" value="'.$begin.'"> - <input type="time" name="end" value="'.$end.'">';
        echo '   Интервал: ';
        echo '<input type="text" name="space" value="'.$space.'">';
    ?>
    <input class="button_blue" type="submit" name="timeset" value="Изменить"><br>
</form>
    <div class="lab">Изменить права пользователя:</div><br>
<form name="qqq" action="" method="post">
    <input list="user" name="user_role" onChange='document.qqq.submit();' autocomplete="off" value="<?php
																										if(isset($_POST['user_role']))
																										{
																											$user_id=(int)antisql($connect, $_POST['user_role']);
																											$us=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `fio`, `role` FROM `user` WHERE `id`='$user_id'"));
																											$user_fio=$us['fio'];
																											$user_role=$us['role'];
																											echo $user_id;
																										}
																									?>">
    <datalist id="user">
    <?php
        $users=mysqli_query($connect, "SELECT `id`,`fio`,`role` FROM `user`");
        while($user=mysqli_fetch_assoc($users))
        {
            $id=$user['id'];
            $fio=$user['fio'];
            $role=$user['role'];
            echo '<option value="'.$id.'">'.$fio.'</option>';
        }
    ?>
    </datalist>
</form>
<form action="lk/vendor/settings.php" method="post">
	<input type="hidden" name="user_role" value="<? echo $user_id; ?>">
    <input type="radio" name="role" value="1" <? if($user_role==1) echo 'checked'; ?>>Пользователь
    <input type="radio" name="role" value="2" <? if($user_role==2) echo 'checked'; ?>>Менеджер
    <input type="radio" name="role" value="3" <? if($user_role==3) echo 'checked'; ?>>Администратор<br>
    <input class="button_blue" type="submit" name="setrole" value="Изменить"><br>
</form>

    <div class="lab">Удалить пользователя:<br></div>
<form action="lk/vendor/settings.php" method="post">
    <input list="user" name="user_del" autocomplete="off">
    <datalist id="user">
    <?php
        $users=mysqli_query($connect, "SELECT `id`,`fio`,`role` FROM `user`");
        while($user=mysqli_fetch_assoc($users))
        {
            $id=$user['id'];
            $fio=$user['fio'];
            $role=$user['role'];
            echo '<option value="'.$id.'">'.$fio.'</option>';
        }
    ?>
    </datalist><br>
    <input class="button_blue" type="submit" name="delete" value="Удалить"><br>
</form>
    </div>
	</div>
</body>
</html>
<?php
    mysqli_close($connect);
?>