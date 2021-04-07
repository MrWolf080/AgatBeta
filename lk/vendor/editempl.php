<?php
    session_start();
    require_once 'db_connection.php';

    $i=1;
    while(!isset($_POST['chang'.$i])&&!isset($_POST['del'.$i]))
        $i++;

    $id=antisql($connect,$_POST[$i]);
    $fio=antisql($connect,$_POST['fio'.$i]);
    $email=antisql($connect,$_POST['email'.$i]);
    $descr=antisql($connect,$_POST['descr'.$i]);

    function preg_grep_keys($pattern, $input, $flags = 0)
    {
        return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
    }
    $a1=array_keys(preg_grep_keys("/^\d*\+\d*/", $_POST));
    if(!empty( $_FILES['image'.$i]['name'] ))
        if ($_FILES['image'.$i]['error'] == 0)
            if(substr($_FILES['image'.$i]['type'], 0, 5)=='image')
                $photo=mysqli_real_escape_string($connect, file_get_contents($_FILES['image'.$i]['tmp_name']));
    if(isset($_POST['del'.$i]))
    {
        mysqli_query($connect, "DELETE FROM `emplserv` WHERE `id_empl`='$id'");
        mysqli_query($connect, "DELETE FROM `record` WHERE `id_empl`='$id'");
        $query=mysqli_query($connect, "DELETE FROM `empl` WHERE `id`='$id'");
        if(mysqli_affected_rows($connect)>0)
        {
            $_SESSION['good_message']='Успешно удалено';
            header('Location: ../../employers.php');
            exit;
        }
        else
        {
            $_SESSION['bad_message']='Ошибка удаления';
            header('Location: ../../admin/editempl.php');
            exit;
        }
    }
    else if(isset($_POST['chang'.$i]))
    {
        mysqli_query($connect, "DELETE FROM `emplserv` WHERE `id_empl`='$id'");
        for($i=0;$i<count($a1, COUNT_RECURSIVE);$i++)
        {
            $pos=strpos($a1[$i], "+");
            $id_empl=(int)antisql($connect,substr($a1[$i],0,$pos));
            if($id_empl!=$id)
                continue;
            $id_serv=(int)antisql($connect,substr($a1[$i],$pos+1,strlen($a1[$i])));
            $query=mysqli_query($connect, "INSERT INTO `emplserv` (`id`, `id_serv`, `id_empl`) VALUES(NULL, '$id_serv', '$id_empl')");
            if(mysqli_affected_rows($connect)==0)
            {
                $_SESSION['bad_message']='Ошибка создания связи';
                header('Location: ../../admin/editservice.php');
                exit;
            }
        }
        if(!isset($photo))
            $query=mysqli_query($connect, "UPDATE `empl` SET `fio`='$fio', `email`='$email', `descr`='$descr' WHERE `id`='$id'");
        else
            $query=mysqli_query($connect, "UPDATE `empl` SET `fio`='$fio', `email`='$email', `descr`='$descr', `photo`='$photo' WHERE `id`='$id'");
        if($query)
        {
            $_SESSION['good_message']='Успешно изменено';
            header('Location: ../../employers.php');
            exit;
        }
        else
        {
            $_SESSION['bad_message']='Ошибка изменения';
            header('Location: ../../admin/editempl.php');
            exit;
        }
    }
    mysqli_close($connect);
?>

