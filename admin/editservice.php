<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/style_editservice.css" type="text/css">
<link rel="stylesheet" href="../styles/style_header_footer.css" type="text/css">
<title>Редактирование услуги</title>
<link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    </head>
    <body>
    <style type="text/css">
            #hellopreloader_preload {
                display: block;
                position: fixed;
                z-index: 99999;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: #333 url(http://hello-site.ru//main/images/preloads/oval.svg) center center no-repeat;
                background-size: 118px;
                margin: 0 auto;
            }


        </style>
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
               <a class="nav__link" href="/employers.php">Сотрудники</a>
               <a class="nav__link" href="/records.php">Записаться</a>
               <a class="nav__link" href="/services.php">Услуги и цены</a>
               <a class="nav__link" href="#footer">Контакты</a>
               <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank"> <i class="fab fa-instagram"></i> </a>
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
                </div>
            </nav>
            <button class="nav-toggle" id="nav_toggle" type="button">
                <span class="nav-toggle__item">menu</span>
            </button>
        </div>
    </div>
</header>
<div class="admin__buttons">
    <?php
        if($_SESSION['user'])
        {
                if($_SESSION['user']['role']==3)
                {
                    ?>
                    <a href="addservice.php" class="button purple adm">Добавить услугу</a>
                    <?
                }
        }
    ?>
</div>
<div class="not_enough">
    <?php
        if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
        {
            ?>
            У вас нет прав для работы с этой страницей<br>
            <?
            exit;
        }
    ?>
</div>
<div class="notempl">
    <?
        $count_empl_q=mysqli_query($connect, "SELECT COUNT(*) FROM `service`");
        $count_empl=mysqli_fetch_array($count_empl_q)[0];
        if($count_empl==0)
        {
            ?>
            Услуг пока нет.<br>
            <?
        }
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
                        ?>
                        <input type="hidden" name="<? echo $i; ?>" value="<? echo $id; ?>">
                        Название:<input type="text" value="<? echo $name; ?>" name="name<? echo $i; ?>"  style="width: 60%;"><br>
                        Описание:
                        <textarea id="textComment" name="descr<? echo $i; ?>"  style="padding-bottom:250px ;  font-size:16px;  height: 50px;  width: 60%;" ><? echo $descr; ?></textarea><br>
                        Цена:<input type="text" value="<? echo $price; ?>" name="price<? echo $i; ?>" style="width: 60%;"><br>
                        Среднея длительность:<input type="text" value="<? echo $cont; ?>" name="cont<? echo $i; ?>" style="width: 60%;"><br>
                        <div class="check__list">
                            <h4><center><b>Выберите мастеров, которые выполняют данную услугу:</b></center></h4>
                            <div class="fu">
                                <?
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
                                                ?>
                                                <label><input type="checkbox" name="<? echo $id; ?>+<? echo $id_empl; ?>" checked><? echo $fio; ?></label><br>
                                                <?
                                            }
                                            else
                                            {
                                                ?>
                                                <label><input type="checkbox" name="<? echo $id; ?>+<? echo $id_empl; ?>" ><? echo $fio; ?></label><br>
                                                <?
                                            }
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="butt">
                            <button type="submit" name="chang<? echo $i; ?>">Изменить</button>
                            <button type="submit" name="del<? echo $i; ?>">Удалить</button><br><br>
                        </div>
                        <?
                    }
                ?>
            </div>
        </form>
        <?
    }
?>
<?php
    mysqli_close($connect);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/main.js"></script>
    </body>
</html>
