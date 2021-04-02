<? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Запись</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
<link rel="stylesheet" href="styles/stylelog.css">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
   <header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a class="header__logo" href="../index.php">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="#">О нас</a>
                        <a class="nav__link" href="#">Сотрудники</a>
                        <a class="nav__link" href="#">Галерея</a>
                        <a class="nav__link" href="#">Услуги и цены</a>
                        <a class="nav__link" href="#">Контакты</a>
                        <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a id="login" class="button blue" href="lk/auth.php">
                            <i class="fa fa-unlock"></i>
                            <span>Войти</span>
                        </a>
                        <a id="register" class="button purple" href="lk/reg.php">
                            <i class="fa fa-user-plus"></i>
                            <span>Зарегистрироваться</span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>
    <div class="content__reg"> </div>
    <?php require_once 'lk/vendor/date.php'; ?>
        <?php
    if($_SESSION['message'])
    {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
            <?php
    if($_SESSION['user'])
    {
        if($_SESSION['user']['role']>1)
        {
            echo '<a href="admin/recordsempl.php">???????? ??????? ?? ??????????</a>';
            echo '<a href="admin/recordsserv.php">???????? ??????? ?? ???????</a>';
        }
    }
?>
                <form name='qqq' action="" method="post">
                    <input type="date" name="date" value="<?php
                                            if(isset($_POST['date']))
                                                echo $_POST['date'];
                                        ?>">
                    <select name="service" onChange='document.qqq.submit();'>
                        <option value="<?php
                            if(isset($_POST['service']))
                                echo $_POST['service'];
                        ?>">
                            <?php
                        if(isset($_POST['service']))
                        {
                            $id_serv=(int)antisql($connect,$_POST['service']);
                            $name=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_serv'"))['name'];
                            echo $name;
                        }
                        ?>
                        </option>
                        <?php
                $query=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
                while($serv=mysqli_fetch_assoc($query))
                {
                    $id_serv=$serv['id'];
                    $name=$serv['name'];
                    echo '<option value="'.$id_serv.'" name="'.$name.'">'.$name.'</option>';
                }
            ?>
                    </select>
                    <select name='empl'>
                        <option value="<?php
                            if(isset($_POST['empl']))
                                echo $_POST['empl'];
                        ?>">
                            <?php
                        if(isset($_POST['empl']))
                        {
                            $id_serv=(int)antisql($connect,$_POST['empl']);
                            $name=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `fio` FROM `empl` WHERE `id`='$id_serv'"))['fio'];
                            echo $name;
                        }
                        ?>
                        </option>
                        <?php
                $id_serv=antisql($connect,$_POST['service']);
                $query1=mysqli_query($connect, "SELECT `id_empl` FROM `emplserv` WHERE `id_serv`='$id_serv'");
                while($id_empl=mysqli_fetch_assoc($query1)['id_empl'])
                {
                    $query2=mysqli_query($connect, "SELECT `fio` FROM `empl` WHERE `id`='$id_empl'");
                    $fio=mysqli_fetch_assoc($query2)['fio'];
                    echo $fio;
                    echo '<option value="'.$id_empl.'">'.$fio.'</option>';
                }
            ?>
                    </select>
                    <input type="submit" name="check" value="Check time"> </form>
                <?php
    if($_POST['date']!=''&&$_POST['service']!=''&&$_POST['empl']!=''&&$_POST['check']!=null)
    {
        $id_serv=(int)antisql($connect, $_POST['service']);
        $id_empl=(int)antisql($connect, $_POST['empl']);
        $time_arr=time_arr($connect);
        $date=antisql($connect,$_POST['date']);
        $set=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `settings`"));
        $begin=substr($set['begin'],0,5);
        $end=substr($set['end'],0,5);
        $mne=time_arr_master_not_empty($connect, $id_empl, $date);
        $servlenth=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `cont` FROM `service` WHERE `id`='$id_serv'"))['cont'];
        $endtime=add_minutes_time($time_arr[0], $servlenth);
        foreach ( $mne as $key => $value )
        {
            foreach($time_arr as $time_key=>$time)
            {
                $endtime=add_minutes_time($time, $servlenth);
                if(!is_interval1_inside_interval2($time, $endtime, $begin, $key)&&$time<=$key||
                    is_in_interval($key, $value, $time)||
                    is_in_interval($key, $value, $endtime)||
                    !is_interval1_inside_interval2($time, $endtime, $value, $end)&&($time>=$value)||
                    $endtime>$end)
                        unset($time_arr[$time_key]);
            }
        }
        if(count($time_arr, COUNT_RECURSIVE)==0)
            echo '????????, ?? ???? ???? ?????? ??????';
        else
        {
            echo '<form action="lk/vendor/records.php" method="post">';
            foreach($time_arr as $time)
                echo '<input type="radio" name="time" value="'.$time.'">'.$time.'<br>';
            echo '<input type="hidden" name="id_serv" value="'.$id_serv.'">';
            echo '<input type="hidden" name="id_empl" value="'.$id_empl.'">';
            echo '<input type="hidden" name="date" value="'.$date.'">';
            echo '<input type="submit" name="rec" value="Make record">';
            echo '</form>';
        }
    }
    mysqli_close($connect);
 ?>
</body>

</html>
