<? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Запись</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
<link rel="stylesheet" href="styles/style_records.css">
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
                    <a class="header__logo" href="index.php">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="index.php#about__us">О нас</a>
                        <a class="nav__link" href="employers.php">Сотрудники</a>
                        <a class="nav__link" href="records.php">Записаться</a>
                        <a class="nav__link" href="services.php">Услуги и цены</a>
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
                </div>
            </div>
    </header>
    <?php require_once 'lk/vendor/date.php'; ?>
    <div class="bad_message">
        <?php
            if($_SESSION['bad_message'])
            {
                echo $_SESSION['bad_message'];
                unset($_SESSION['bad_message']);
            }
        ?>
    </div>
    <div class="good_message">
        <?php
            if($_SESSION['good_message'])
            {
                echo $_SESSION['good_message'];
                unset($_SESSION['good_message']);
            }
        ?>
    </div>
           <div class="content__records">
            <?php
    if($_SESSION['user'])
    {
        if($_SESSION['user']['role']>1)
        {
            ?>
            <h2>Открыть записи сортированные по:</h2>
            <a href="admin/recordsempl.php" style="color: white;font-family: helvetica;text-decoration: none;text-transform: uppercase; margin-top:20%; font-size: 30px;"> сотрудникам</a> <br>
            <a href="admin/recordsserv.php"style="color: white;font-family: helvetica;text-decoration: none;text-transform: uppercase; margin-top:20%; font-size: 30px;">услугам</a>
        <? }
    }
?>
                <form name='qqq' action="" method="post">
                   <div class ="content__records__text">Выберите нужную вам:</div> <div class="choise">
                   <table>
                   <tr><th>дату</th><th>услугу</th><th>мастера</th></tr>
                   <tr>
                   <td>
                    <input type="date" name="date" value="<?php
                                            if(isset($_POST['date']))
                                                echo $_POST['date'];

                                                          ?>"></td>
                                    <td>
                                    <div class="drop__down__list">
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
                                        </select></div></td>
                                        <td>
                    <select name='empl'>
                        <option value="<?php
                            if($_POST['check']!=null&&isset($_POST['empl']))
                                echo $_POST['empl'];
                        ?>">
                            <?php
                        if($_POST['check']!=null&&isset($_POST['empl']))
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
                    </td>
                       </tr>
                    </table>
                    <input type="submit" class="button blue" name="check" value="Выбрать время"></div> </form>
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
            echo '<div class="sorry">Извините, нет свободного времени</div>';
        else
        {
            echo '<div class="fff_list"><form class="time" action="lk/vendor/records.php" method="post">';
            foreach($time_arr as $time)
                echo '<input type="radio" name="time" value="'.$time.'">'.$time.'<br>';
            echo '<input type="hidden" name="id_serv" value="'.$id_serv.'">';
            echo '<input type="hidden" name="id_empl" value="'.$id_empl.'">';
            echo '<input type="hidden" name="date" value="'.$date.'">';
            echo '</div><div class="mace_record"><input type="submit" class=" button blue" name="rec" value="Записаться"></div>';
            echo '</form>';
        }

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

