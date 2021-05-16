<?php
    session_start();
    require_once '../lk/vendor/date.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../styles/header.css" />
	<link rel="stylesheet" type="text/css" href="../styles/style_header_footer.css" />
    <link rel="stylesheet" type="text/css" href="../styles/style_preloader.css" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/js/main.js"></script>
    <title>Записи по сотрудникам</title>
    <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon"/>
</head>
<body>
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
								<?
							}
							else
							{
								?>
								<a id="login" class="button purple" href="../lk/exit.php">
									<i class="fa fa-unlock"></i>
									 <span>Выйти</span>
								</a>
								<?
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
                <input type="date" name="date" value="<? if(isset($_POST['date'])) echo $_POST['date']; else if(isset($_SESSION['post_serv']['date'])) echo $_SESSION['post_serv']['date']; ?>">
                <select name="serv" >
					<?
						if(!isset($_POST['serv'])&&!isset($_SESSION['post_serv']['serv']))
						{
							?>
							<option value=""></option>
							<?
						}
					?>
                    <?php
                        $query=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
                        while($empl=mysqli_fetch_assoc($query))
                        {
                            $id_empl=$empl['id'];
                            $fio=$empl['name'];
                            ?>
                            <option value="<? echo $id_empl; ?>" name="<? echo $fio; ?>"
																						<? 
																							if($_POST['serv']==$id_empl) 
																								echo 'selected'; 
																							else if(!isset($_POST['serv'])&&$_SESSION['post_serv']['serv']==$id_empl) 
																								echo 'selected'; 
																						?>><? echo $fio; ?></option>
							<?
                        }
                    ?>
                </select>
                <input class="button blue" type="submit" value="Показать записи">
            </div>
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
                    {
                        ?>
                        Записей нет
                        <?
                    }
                    while($rec=mysqli_fetch_assoc($query))
                    {
                        $id_serv=$rec['id_empl'];
                        $id_user=$rec['id_user'];
                        $id=$rec['id'];
						$rec_date=substr($rec['date'],0,10);
                        $time=substr($rec['date'],11,5);
                        ?>
                        <input type="date" name="date<? echo $id; ?>" value="<? echo $rec_date; ?>">
                        <?
                        $length=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `cont` FROM `service` WHERE `id`='$id_empl'"))['cont'];
                        $endtime=add_minutes_time($time, $length);
                        ?>
                        <input type="time" name="time<? echo $id; ?>" value="<? echo $time; ?>"> - <? echo $endtime; ?>
                        <?
                        $users=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`fio` FROM `user` WHERE `id`='$id_user'"));
                        $usfio=$users['fio'];
                        $usid=$users['id'];
                        ?>
                        <input list="user" id="user<? echo $id; ?>" autocomplete="off" name="user<? echo $id; ?>" value="<? echo $usfio; ?>">
                            <datalist id="user" >
                            <?
                            $query1=mysqli_query($connect, "SELECT * FROM `user`");
                            while($user=mysqli_fetch_assoc($query1))
                            {
                                $user_fio=$user['fio'];
                                $user_id=$user['id'];
                                ?>
                                <option value="<? echo $user_id; ?>"><? echo $user_fio; ?></option>
                                <?
                            }
                            ?>
                            </datalist>
                        <?
                        $services=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`fio` FROM `empl` WHERE `id`='$id_serv'"));
                        $name=$services['fio'];
                        $servid=$services['id'];
                        ?>
                        <input list="serv" autocomplete="off" name="empl<? echo $id; ?>" value="<? echo $name; ?>">
                            <datalist id="serv" >
                            <?
                            $query2=mysqli_query($connect, "SELECT * FROM `empl`");
                            while($serv=mysqli_fetch_assoc($query2))
                            {
                                $serv_name=$serv['fio'];
                                $serv_id=$serv['id'];
                                ?>
                                <option value="<? echo $serv_id; ?>"><? echo $serv_name; ?></option>
                                <?
                            }
                            ?>
                            </datalist>
                        <input type="submit" class= "button blue" name="show<? echo $id; ?>" value="Показать клиента">
                        <input type="submit" class= "button blue" name="chang<? echo $id; ?>" value="Изменить">
                        <input type="submit" class= "button blue" name="del<? echo $id; ?>" value="Удалить">
                        <br>
                        <?
                    }
                }
            ?>
        </form>
        <?php
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
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                        else
                        {
                            $_SESSION['bad_message']='Ошибка измененения';
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                    }
                    else if($id_user==0)
                    {
                        $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_empl`='$id_empl' WHERE `id`='$id'");
                        if($query)
                        {
                            $_SESSION['good_message']='Успешно изменено';
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                        else
                        {
                            $_SESSION['bad_message']='Ошибка измененения';
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                    }
                    else if($id_empl==0)
                    {
                        $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_user`='$id_user' WHERE `id`='$id'");
                        if($query)
                        {
                            $_SESSION['good_message']='Успешно изменено';
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                        else
                        {
                            $_SESSION['bad_message']='Ошибка измененения';
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                    }
                    else
                    {
                        $query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_empl`='$id_empl', `id_user`='$id_user' WHERE `id`='$id'");
                        if($query)
                        {
                            $_SESSION['good_message']='Успешно изменено';
                            echo "<script>window.location.href='recordsserv.php';</script>";
                            exit;
                        }
                        else
                        {
                            $_SESSION['bad_message']='Ошибка измененения';
                            echo "<script>window.location.href='recordsserv.php';</script>";
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
                        echo "<script>window.location.href='recordsserv.php';</script>";
                        exit;
                    }
                    else
                    {
                        $_SESSION['bad_message']='Ошибка удаления';
                        echo "<script>window.location.href='recordsserv.php';</script>";
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
    
</body>
</html>
