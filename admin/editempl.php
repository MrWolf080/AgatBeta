<?php
    session_start();
    require_once '../lk/vendor/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактирование сотрудника</title>
    <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../styles/style_editempl.css"/>
    <link rel="stylesheet" type="text/css" href="../styles/style_header_footer.css"/>
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
                        <?php
                            }
                            else
                            {
                            ?>
                                <a id="login" class="button purple" href="../lk/exit.php">
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
                    <a href="addempl.php" class="button purple adm">Добавить сотрудника</a>
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
        $count_empl_q=mysqli_query($connect, "SELECT COUNT(*) FROM `empl`");
        $count_empl=mysqli_fetch_array($count_empl_q)[0];
        if($count_empl==0)
        {
            ?>
            Сотрудников пока нет.<br>
            <?
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
                        ?>
                        <label>Обновите фото (соотношение сторон 7х10)</label>
                        <input type="file" name="image<? echo $i; ?>" /><br>
                        <img src="data:image/*;base64,<? echo base64_encode($arr['photo'])?>" height="400" width="280" loading="lazy"/><br>
                        <input type="hidden" name="<? echo $i; ?>" value="<? echo $id; ?>">
                        <div class="cont">
                            <table>
                                <tr>
                                    <td><h3>ФИО</h3></td>
                                    <td>
                                        <input type="text" value="<? echo $fio; ?>" name="fio<? echo $i; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><h3>Почта</h3></td>
                                    <td>
                                        <input type="text" value="<? echo $email; ?>" name="email<? echo $i; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><h3>Описание</h3></td>
                                    <td>
                                        <textarea id="textComment" name="descr<? echo $i; ?>" style="padding-bottom:250px ;  font-size:16px;  height: 50px;"><? echo $descr; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <b>Список услуг, которые сотрудник осуществляет:</b><br>
                        <div class="checkbox_list">
                        <?
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
                                        ?>
                                        <label><input type="checkbox" name="<? echo $id; ?>+<? echo $id_serv; ?>" checked><? echo $name; ?><br></label>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <label><input type="checkbox" name="<? echo $id; ?>+<? echo $id_serv; ?>" ><? echo $name; ?><br></label>
                                        <?
                                    }
                                }
                            }
                        ?>
                        </div>
                        <button type="submit" name="chang<? echo $i; ?>">Изменить</button>
                        <button type="submit" name="del<? echo $i; ?>">Удалить</button><br><br>
                        <?
                    }
                ?>
            </div>
        </form>
        <?
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/main.js"></script>

</body>
</html>

<?
    mysqli_close($connect);
?>


