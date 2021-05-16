<?
    session_start();
    require_once 'lk/vendor/date.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Запись</title>
        <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon"/>
        <link rel="stylesheet" href="styles/style_records.css"/>
        <link rel="stylesheet" href="styles/style_header_footer.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="../styles/style_preloader.css" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
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
        <div class="body__bgr">
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
            <div class="wrapper">
                <div class="content">
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
                    if($_SESSION['user']&&$_SESSION['user']['role']>1)
					{
						?>
						<center>
							<h2>Открыть записи сортированные по:</h2>
							<div class="wrapper1">
								<a href="admin/recordsempl.php" class="button purple adm"> сотрудникам</a> 
								<a href="admin/recordsserv.php" class="button purple adm">услугам</a>
							</div>
						</center>
						<?
					}
                    ?>
                                <form name='qqq' action="" method="post">
                                    <div class="content__records__text">Выберите нужную вам:</div>
                                    <div class="choise small">
                                        <table>
                                            <tr> дату
                                                <br> </tr>
                                            <tr>
                                                <input type="date" padding="10px" name="date" value="<?php if(isset($_POST['date'])) echo $_POST['date']; ?>"> </tr>
                                        </table>
                                        <table>
                                            <tr> услугу
                                                <br> </tr>
                                            <tr>
                                                <div class="drop__down__list">
                                                    <select name="service" onChange='document.qqq.submit();'>
														<? 
															if(!isset($_POST['service']))
															{
																?>
																<option value=""></option>
																<?
															}
														?>
                                                        <?php
															$query=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
															while($serv=mysqli_fetch_assoc($query))
															{
																$id_serv=$serv['id'];
																$name=$serv['name'];
																?>
																<option value="<? echo $id_serv; ?>" name="<? echo $name; ?>" <? if($_POST['service']==$id_serv) echo 'selected';?>><? echo $name; ?></option>
																<?
															}
														?>
                                                    </select>
                                                </div>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr> мастера
                                                <br> </tr>
                                            <tr>
                                                <select name='empl'>
													<? 
														if(!isset($_POST['empl'])||$_POST['empl']=='')
														{
															?>
															<option value=""></option>
															<?
														}
													?>
                                                    <?php
														$id_serv=antisql($connect,$_POST['service']);
														$query1=mysqli_query($connect, "SELECT `id_empl` FROM `emplserv` WHERE `id_serv`='$id_serv'");
														while($id_empl=mysqli_fetch_assoc($query1)['id_empl'])
														{
															$query2=mysqli_query($connect, "SELECT `fio` FROM `empl` WHERE `id`='$id_empl'");
															$fio=mysqli_fetch_assoc($query2)['fio'];
															echo $fio;
															?>
															<option value="<? echo $id_empl; ?>" <? if($_POST['empl']==$id_empl) echo 'selected'; ?>><? echo $fio; ?></option>
															<?
														}
													?>
                                                </select>
                                            </tr>
                                        </table>
                                        <input type="submit" class="button blue" name="check" value="Выбрать время" />
                                        </div>
                                </form>
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
                            {
                                ?>
                                    <div class="sorry">Извините, нет свободного времени</div>
                                    <?
                            }
                            else
                            {
                                ?>
                                        <div class="fff_list">
                                            <form class="time" action="lk/vendor/records.php" method="post">
                                                <select name="time">
                                                    <?
                                            foreach($time_arr as $time)
                                            {
                                            ?>
                                                        <option value="<? echo $time;?>">
                                                            <? echo $time; ?>
                                                        </option>
                                                        <?
                                            }
                                            ?>
                                                </select>
                                                <input type="hidden" name="id_serv" value="<? echo $id_serv; ?>">
                                                <input type="hidden" name="id_empl" value="<? echo $id_empl; ?>">
                                                <input type="hidden" name="date" value="<? echo $date; ?>">
                                                <div class="mace_record">
                                                    <input type="submit" class=" button blue" name="rec" value="Записаться"> </div>
                                            </form>
                                        </div>
                                        <?
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <footer class="footer" id="footer">
                <div class="container">
                    <div class="footer__inner">
                        <table>
                            <tr>
                                <td><a class="footer__logo" href="/index.php">AgaT</a></td>
                                <td>
                                    <div class="footer__text"> Каждая женщина уникальна и индивидуальна.
                                        <br>А наши специалисты помогут вам ухаживать за вашей природной красотой. </div>
                                </td>
                                <td>
                                    <div class="footer__text1"> Подписывайтесь на наш инстаграм: </div>
                                    <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank"> <i class="fab fa-instagram"></i> </a>
                                </td>
                                <td>
                                    <div class="footer__phone" align="right">+7(908)517-73-00</div>
                                    <div class="footer__adress" align="right">Ростов-на-Дону ул. Пулковская 36</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </footer>
        </div>
        
    </body>

    </html>
    <? mysqli_close($connect); ?>
