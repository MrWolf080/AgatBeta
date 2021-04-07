<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="shortcut icon" href="/img/titlepic.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style_auth.css" type="text/css">
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
    if($_SESSION['message'])
    {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<?php
    if($_SESSION['user'])
    {
        echo 'Вы уже авторизованы';
        exit;
    }
?>
</div>
<form action="" method="post">
    <div class="form">
        <div class="label_auth_reg">Вход</div>
        <div class="haveacc">
          <label>ФИО или email</label>
          <br>
          <input type="text" name="fio" placeholder="Введите свой логин" value="<?if($_SESSION['post']) echo $_SESSION['post']['fio'];?>">
          <br>
          <label>Пароль</label>
          <br>
           <input type="password" name="password" placeholder="Введите пароль">
          <br>
         <button type="submit" name="auth" class="button blue"><i class="fa fa-unlock"></i><span>Войти</span></button>
           <p>
               <b>У вас нет аккаунта?</b> - <a href="../lk/reg.php" class="button purple"><i class="fa fa-user-plus"></i>Зарегистрируйтесь</a>
           </p>
       </div>
    </div>
</form>
</div>
<?php
    unset($_SESSION['post']);
    if(isset($_POST['auth']))
    {
        $_SESSION['post']=$_POST;
        require_once 'vendor/db_connection.php';

        $fio=$_POST['fio'];
        $pass=md5($_POST['password']);

        $check_user=mysqli_query($connect, "SELECT * FROM `user` WHERE (`fio`='$fio' OR `email`='$fio') AND `password`='$pass'");
        if(!$check_user)
        {
            $_SESSION['message']='Неизвестная ошибка';
            echo "<script>window.location.href='auth.php';window.location.replace('auth.php');</script>";
            exit;
        }

        if(!(mysqli_num_rows($check_user)>0))
        {
            $_SESSION['message']='Ошибка: неверны ФИО, email или пароль';
            echo "<script>window.location.href='auth.php';window.location.replace('auth.php');</script>";
            exit;
        }

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
