<?php
    session_start();
    require_once '../lk/vendor/date.php';
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
<title>Записи по сотрудникам</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
</head>
<body>
<header class = "header">
    <div class="container">
        <div class="header__inner">
            <a href="../
            " class="header__logo">AgaT</a>
            <nav class="nav">
                <a class="nav__link" href="../index.php#about__us">О нас</a>
                <a class="nav__link" href="/employers.php">Сотрудники</a>
                <a class="nav__link" href="/records.php">Записаться</a>
                <a class="nav__link" href="/services.php">Услуги и цены</a>
                <a class="nav__link" href="/index.php#footer">Контакты</a>
                <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <?
                    if($_SESSION['user'])
                    {
                    ?>
                        <a id="login" class="button_purple" href="/lk/exit.php">
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
    <?php
        if(!$_SESSION['user']||!$_SESSION['user']['role']>1)
        {
            echo 'У вас нет прав для работы с этой страницей<br>';
            exit;
        }
    ?>
</div>
<div class="recordsempl__container">
    <form name='qqq' action="" method="post">
       <div class="color_for_form">
        <input type="date" name="date" value="<?php
            if(isset($_POST['date']))
                    echo $_POST['date'];
                else if(isset($_SESSION['post_serv']['date']))
                    echo $_SESSION['post_serv']['date'];
        ?>">
        <select name="serv" >
            <option value="<?php
                if(isset($_POST['serv']))
                        echo $_POST['serv'];
                    else if(isset($_SESSION['post_serv']['serv']))
                        echo $_SESSION['post_serv']['serv'];
            ?>">
            <?php
            if(isset($_POST['serv']))
            {
                $id_empl=antisql($connect,$_POST['serv']);
                $fio=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_empl'"))['name'];
                echo $fio;
            }
            else if(isset($_SESSION['post_serv']['serv']))
            {
                $id_empl=antisql($connect,$_SESSION['post_serv']['serv']);
                $fio=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_empl'"))['name'];
                echo $fio;
            }
            ?>

</option>
                <?php
                    $query=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
                    while($empl=mysqli_fetch_assoc($query))
                    {
                        $id_empl=$empl['id'];
                        $fio=$empl['name'];
                        echo '<option value="'.$id_empl.'" name="'.$fio.'">'.$fio.'</option>';
                    }
                ?>
        </select>
           <input class="button_blue" type="submit" value="Show records"> </div>
        <br>
        <?php
            unset($_SESSION['post_serv']);
            if(isset($_POST['serv'])&&isset($_POST['date'])||isset($_SESSION['post_serv2']))
            {
                $_SESSION['post_serv']=$_POST;
                if(isset($_POST['serv'])&&isset($_POST['date']))
                {
                    $datesql=antisql($connect, $_POST['date']).'%';
                    $date=antisql($connect, $_POST['date']);
                    $id_empl=(int)antisql($connect, $_POST['serv']);
                }
                else if(isset($_SESSION['post_serv2']))
                {
                    $datesql=antisql($connect, $_SESSION['post_serv2']['date']).'%';
                    $date=antisql($connect, $_SESSION['post_serv2']['date']);
                    $id_empl=(int)antisql($connect, $_SESSION['post_serv2']['serv']);
                }
                $query=mysqli_query($connect, "SELECT * FROM `record` WHERE `id_serv` = '$id_empl' AND `date` LIKE '$datesql'");
                if(mysqli_num_rows($query)==0)
                    echo 'Записей нет';
                while($rec=mysqli_fetch_assoc($query))
                {
                    $id_serv=$rec['id_empl'];
                    $id_user=$rec['id_user'];
                    $id=$rec['id'];
                    $time=substr($rec['date'],11,5);
                    echo '<input type="date" name="date'.$id.'" value="'.$date.'">';

                    $length=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `cont` FROM `service` WHERE `id`='$id_empl'"))['cont'];
                    $endtime=add_minutes_time($time, $length);
                    echo '<input type="time" name="time'.$id.'" value="'.$time.'"> - '.$endtime.' ';

                    $users=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`fio` FROM `user` WHERE `id`='$id_user'"));
                    $usfio=$users['fio'];
                    $usid=$users['id'];
                    echo '<input list="user" id="user'.$id.'" autocomplete="off" name="user'.$id.'" value="'.$usfio.'">';
                    echo '<datalist id="user" >';
                    $query1=mysqli_query($connect, "SELECT * FROM `user`");
                    while($user=mysqli_fetch_assoc($query1))
                    {
                        $user_fio=$user['fio'];
                        $user_id=$user['id'];
                        echo '<option value="'.$user_id.'">'.$user_fio.'</option>';

                    }
                    echo '</datalist>';

                    $services=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`fio` FROM `empl` WHERE `id`='$id_serv'"));
                    $name=$services['fio'];
                    $servid=$services['id'];
                    echo '<input list="serv" autocomplete="off" name="empl'.$id.'" value="'.$name.'">';
                    echo '<datalist id="serv" >';
                    $query2=mysqli_query($connect, "SELECT * FROM `empl`");
                    while($serv=mysqli_fetch_assoc($query2))
                    {
                        $serv_name=$serv['fio'];
                        $serv_id=$serv['id'];
                        echo '<option value="'.$serv_id.'">'.$serv_name.'</option>';
                    }
                    echo '</datalist>';

                    echo '<input type="submit" class= "button_blue" name="show'.$id.'" value="Показать клиента">';
                    echo '<input type="submit" class= "button_blue" name="chang'.$id.'" value="Изменить">';
                    echo '<input type="submit" class= "button_blue" name="del'.$id.'" value="Удалить">';
                    echo '<br>';
                }
            }
        ?>
    </form>

<?php
    require_once '../lk/vendor/db_connection.php';

    $keys=array_keys($_POST);
    foreach($keys as $value)
    {
        preg_match("/show(\d+)/",$value,$a);
        if($a)
            break;
        preg_match("/chang(\d+)/",$value,$a);
        if($a)
            break;
        preg_match("/del(\d+)/",$value,$a);
        if($a)
            break;
    }
    unset($_SESSION['post_serv2']);
    if(isset($a[1]))
    {
        $_SESSION['post_serv2']=$_POST;
        $id=$a[1];
        $date=antisql($connect, $_POST['date'.$id]);
        $time=antisql($connect, $_POST['time'.$id]);
        $id_user=(int)antisql($connect, $_POST['user'.$id]);
        $id_empl=(int)antisql($connect, $_POST['empl'.$id]);
        $datetime=$date.' '.$time;

        if(isset($_POST['chang'.$id]))
        {
            if($id_user==0&&$id_empl==0)
            {
                $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime' WHERE `id`='$id'");
                if($query)
                {
                    $_SESSION['good_message']='Успешно изменено';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
                else
                {
                    $_SESSION['bad_message']='Ошибка измененения';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
            }
            else if($id_user==0)
            {
                $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_empl`='$id_empl' WHERE `id`='$id'");
                if($query)
                {
                    $_SESSION['good_message']='Успешно изменено';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
                else
                {
                    $_SESSION['bad_message']='Ошибка измененения';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
            }
            else if($id_empl==0)
            {
                $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_user`='$id_user' WHERE `id`='$id'");
                if($query)
                {
                    $_SESSION['good_message']='Успешно изменено';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
                else
                {
                    $_SESSION['bad_message']='Ошибка измененения';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
            }
            else
            {
                $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_empl`='$id_empl', `id_user`='$id_user' WHERE `id`='$id'");
                if($query)
                {
                    $_SESSION['good_message']='Успешно изменено';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }
                else
                {
                    $_SESSION['bad_message']='Ошибка измененения';
                    echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                    exit;
                }

            }
        }
        else if(isset($_POST['del'.$id]))
        {
            $query=mysqli_query($connect, "DELETE FROM `record` WHERE `id`='$id'");
            if(mysqli_affected_rows($connect)>0)
            {
                $_SESSION['good_message']='Успешно удалено';
                echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                exit;
            }
            else
            {
                $_SESSION['bad_message']='Ошибка удаления';
                echo "<script>window.location.href='recordsserv.php';window.location.replace('recordsserv.php');</script>";
                exit;
            }
        }
        else if(isset($_POST['show'.$id]))
        {
            $query=mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = (SELECT `id_user` FROM `record` WHERE `id`='$id')");
            $user=mysqli_fetch_assoc($query);
            $user_id=$user['id'];
            $fio=$user['fio'];
            $email=$user['email'];
            $tel=$user['tel'];
            ?>
           <div class="user__info">
              <table>
                 <colgroup>
                   <col span="1" align="right">
                 </colgroup>
                  <tr><td><b>Номер:</b></td><td> <? echo $user_id;?></td></tr>
                  <tr><td><b>ФИО:</b></td><td> <? echo $fio.'<br>'; ?></td></tr>
               <tr><td><b>email:</b></td><td> <? echo $email.'<br>'; ?></td></tr>
               <tr><td><b>Телефон:</b></td><td> <? echo $tel.'<br>'; ?></td></tr>
               </table>
           </div>
            <?php
        }
    }
    mysqli_close($connect);
?>
</div>
