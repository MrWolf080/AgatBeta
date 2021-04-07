<?php
    session_start();
    require_once 'db_connection.php';

    $name=antisql($connect, $_POST['name']);
    $descr=antisql($connect, $_POST['descr']);
    $price=(int)antisql($connect, $_POST['price']);
    $cont=(int)antisql($connect, $_POST['cont']);
    unset($_POST['name']);
    unset($_POST['descr']);
    unset($_POST['price']);
    unset($_POST['cont']);
    $ids=array_keys($_POST);

    $query="INSERT INTO `service` (`id`, `name`, `descr`, `price`, `cont`) VALUES(NULL, '$name', '$descr', '$price', '$cont')";
    $resq=mysqli_query($connect, $query);
    if(mysqli_affected_rows($connect)==0)
    {
        $_SESSION['message']='Неизвестная ошибка при создании услуги';
        header('Location: ../../admin/addservice.php');
        exit;
    }
    $query=mysqli_query($connect, "SELECT `id` FROM `service` WHERE `name`='$name' AND `descr`='$descr' AND `price`='$price' AND `cont`='$cont'");
    if(mysqli_num_rows($query)==0)
    {
        $_SESSION['message']='Неизвестная ошибка при поиске id услуги';
        header('Location: ../../admin/addservice.php');
        exit;
    }
    $id_serv=mysqli_fetch_assoc($query)['id'];
    for($i=0;$i<count($ids, COUNT_RECURSIVE);$i++)
    {
        $id_empl=$ids[$i];
        $query=mysqli_query($connect, "INSERT INTO `emplserv` (`id`, `id_serv`, `id_empl`) VALUES(NULL, '$id_serv', '$id_empl')");
        if(!$query)
        {
            $_SESSION['message']='Неизвестная ошибка при создании связей с мастерами';
            mysqli_query($connect, "DELETE FROM `service` WHERE `id`='$id_serv'");
            header('Location: ../../admin/addservice.php');
            exit;
        }
    }
    $_SESSION['message']='Успешно добавлено';
    header('Location: ../../services.php');
    exit;
    mysqli_close($connect);
?>
