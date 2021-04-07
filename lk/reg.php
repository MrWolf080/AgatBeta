<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="shortcut icon" href="/img/titlepic.png" >
    <link rel="stylesheet" href="../styles/style_reg.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tenor+Sans" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Italianno" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marck+Script" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
</head>
<body>
    <div class="body__bgr">
        <header class = "header">
            <div class="container">
                <div class="header__inner">
                    <a class="header__logo" href="../index.php">AgaT</a>
                    <nav class="nav">
                        <a class="nav__link" href="../index.php#about__us">О нас</a>
                        <a class="nav__link" href="../employers.php">Сотрудники</a>
                        <a class="nav__link" href="../records.php">Записаться</a>
                        <a class="nav__link" href="../services.php">Услуги и цены</a>
                        <a class="nav__link" href="#footer">Контакты</a>
                        <a class="nav__link" href="https://www.instagram.com/beauty_studio_agat/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </header>
        <div class="message">
    <?php
        if($_SESSION['good_message'])
        {
            echo $_SESSION['good_message'];
            unset($_SESSION['good_message']);
        }
    ?>
    <?php
        if($_SESSION['user'])
        {
            echo 'Вы уже авторизованы';
            exit;
        }
    ?>
    <?php
        if($_SESSION['bad_message'])
        {
            echo $_SESSION['bad_message'];
            unset($_SESSION['bad_message']);
        }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js" type="text/javascript"></script>
<form action="" method="post">
    <div class="form">
    <div class="label_auth_reg">Регистрация</div>
        <div class="haveacc">
            <div align="right">
                <label>ФИО:</label>
                <input type="text" name="fio" placeholder="Введите свое полное имя" value="<?php if($_SESSION['post']) echo $_SESSION['post']['fio']; ?>">
                <br>
                <label>Почта:</label>
                <input type="email" name="email" placeholder="Введите свой email" value="<?php if($_SESSION['post']) echo $_SESSION['post']['email']; ?>">
                <br>
                <label>Телефон:</label>
                <input type="text" name="tel" id="phone_2" placeholder="Введите ваш номер телефона" value="<?php if($_SESSION['post']) echo $_SESSION['post']['tel']; ?>">
                <br>
                <label>Пароль:</label>
                <input type="password" name="password" placeholder="Введите пароль (4-15 символов)">
                <br>
                <label>Подтвердите пароль:</label>
                <input type="password" name="pass_conf" placeholder="Введите пароль ещё раз">
                <br>
                <div class="capcha">
                    <a href="javascript:void(0);" onclick="document.getElementById('capcha-image').src='vendor/captcha.php?rid=' + Math.random();" class="capcha__link">Обновить капчу</a>
                    <img src='vendor/captcha.php' id='capcha-image'>
                <input type="text" name="code" placeholder="Введите символы с картинки">
                </div>
                <br>

            </div>
            <button type="submit" name="reg" class="button purple"><i class="fa fa-user-plus"></i>Зарегистрироваться</button>
            <p color="">
                <b>У вас уже есть аккаунт?</b> - <a href="auth.php" class="button blue"><i class="fa fa-unlock"></i>Авторизуйтесь</a>
            </p>
        </div>
    </div>
     <script>
             $.fn.setCursorPosition = function(pos) {
          if ($(this).get(0).setSelectionRange) {
            $(this).get(0).setSelectionRange(pos, pos);
          } else if ($(this).get(0).createTextRange) {
            var range = $(this).get(0).createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
          }
        };
     $("#phone_2").click(function(){$(this).setCursorPosition(3);}).mask("+7(999) 999-99-99");
    </script>
</form>
  </div><!-- close div class body__bgr-->
   <?php
    unset($_SESSION['post']);
    function check_code($code, $cap)
    {

        $code = trim($code);
        $code = md5(md5($code));
        $cap = $_SESSION['captcha'];
        $cap = md5(md5($cap));
        if ($code == $cap){return TRUE;}else{return FALSE;}
    }
    $cap = $_SESSION["captcha"];
    if(isset($_POST['reg']))
    {
        $_SESSION['post']=$_POST;
        require_once 'vendor/db_connection.php';

        $fio=antisql($connect, $_POST['fio']);
        $email=antisql($connect, $_POST['email']);
        $tel=antisql($connect, $_POST['tel']);
        $password=$_POST['password'];
        $pass_conf=$_POST['pass_conf'];
        $code=$_POST['code'];


        if($fio==''||$email==''||$tel==''||$password==''||$pass_conf==''||$code=='')
        {
            $_SESSION['bad_message']='Пожалуйста, заполните все поля';
            echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
            exit;
        }

        if($password!=$pass_conf)
        {
            $_SESSION['bad_message']='Ошибка: Пароли не совпадают!';
            echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
            exit;
        }

        if(mb_strlen($password)<4||mb_strlen($password)>15)
        {
            $_SESSION['bad_message']='Ошибка: Длина пароля должна быть в пределах 4-15 символов';
            echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
            exit;
        }

        if (!check_code($code, $cap))
        {
            $_SESSION['bad_message']='Вы неправильно ввели символы с картинки';
            echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
            exit;
        }

        $password=md5(antisql($connect, $password));

        $query=mysqli_query($connect, "INSERT INTO `user` (`id`, `fio`, `email`, `tel`, `password`,`role`) VALUES (NULL, '$fio', '$email', '$tel', '$password',1)");

        if(!$query)
        {
            $_SESSION['bad_message']='Неизвестная ошибка';
            echo "<script>window.location.href='reg.php';window.location.replace('reg.php');</script>";
            exit;
        }
        $_SESSION['good_message']='Регистрация прошла успешно';
        $check_user=mysqli_query($connect, "SELECT * FROM `user` WHERE (`fio`='$fio' OR `email`='$email') AND `password`='$password' AND `email`='$email' AND `tel`='$tel'");
        $user=mysqli_fetch_assoc($check_user);
        $_SESSION['user']=
        [
            "id"=>$user['id'],
            "fio"=>$user['fio'],
            "email"=>$user['email'],
            "role"=>$user['role']
        ];

        mysqli_close($connect);
        echo "<script>window.location.href='../index.php';window.location.replace('../index.php');</script>";
    }
?>
<footer class="footer" id="footer">
            <div class="">
                <div class="footer__inner">
                   <table><tr>
                       <td><a class="footer__logo" href="/index.php">AgaT</a></td>
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

        </footer>
</body>
</html>
