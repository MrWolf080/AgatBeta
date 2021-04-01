<?php
	session_start();
	require_once 'db_connection.php';
	
	$fio=antisql($connect, $_POST['fio']);
	$email=antisql($connect, $_POST['email']);
	$descr=antisql($connect, $_POST['descr']);
	unset($_POST['fio']);
	unset($_POST['email']);
	unset($_POST['descr']);
	$ids=array_keys($_POST);
	
	if(!empty( $_FILES['image']['name'] )) 
	{
		if ($_FILES['image']['error'] == 0) 
		{
			if(substr($_FILES['image']['type'], 0, 5)=='image') 
			{
				$image = file_get_contents($_FILES['image']['tmp_name']);
				$image = mysqli_real_escape_string($connect, $image);
				$query="INSERT INTO `empl` (`id`, `fio`, `email`, `descr`, `photo`) VALUES(NULL, '$fio', '$email', '$descr', '$image')";
				$resq=mysqli_query($connect, $query);
				if(mysqli_affected_rows($connect)==0)
				{
					$_SESSION['message']='Неизвестная ошибка';
					header('Location: ../../admin/addempl.php');
					exit;
				}
				$query=mysqli_query($connect, "SELECT `id` FROM `empl` WHERE `fio`='$fio' AND `email`='$email' AND `descr`='$descr' AND `photo`='$image'");
				if(mysqli_num_rows($query)==0)
				{
					$_SESSION['message']='Неизвестная ошибка при поиске id сотрудника';
					header('Location: ../../admin/addservice.php');
					exit;
				}
				$id_empl=mysqli_fetch_assoc($query)['id'];
				for($i=0;$i<count($ids, COUNT_RECURSIVE);$i++)
				{
					$id_serv=$ids[$i];
					$query=mysqli_query($connect, "INSERT INTO `emplserv` (`id`, `id_serv`, `id_empl`) VALUES(NULL, '$id_serv', '$id_empl')");
					if(!$query)
					{
						$_SESSION['message']='Неизвестная ошибка при создании связей с услугами';
						header('Location: ../../admin/addservice.php');
						exit;
					}
				}
				header('Location: ../../employers.php');
				exit;
			}
			else
			{
				$_SESSION['message']='Загружен не графический файл';
				header('Location: ../../admin/addempl.php');
				exit;
			}
		}
		else
		{
			$_SESSION['message']='Неизвестная ошибка при загрузке файла';
			header('Location: ../../admin/addempl.php');
			exit;
		}
	}
	else
	{
		$_SESSION['message']='Файл не отправлен';
		header('Location: ../../admin/addempl.php');
		exit;
	}
	mysqli_close($connect);
?>