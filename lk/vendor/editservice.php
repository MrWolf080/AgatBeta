<?php
	session_start();
	require_once 'db_connection.php';
	
	$i=1;
	while(!isset($_POST['chang'.$i])&&!isset($_POST['del'.$i]))
		$i++;
	
	$id=antisql($connect,$_POST[$i]);
	$name=antisql($connect,$_POST['name'.$i]);
	$price=(int)antisql($connect,$_POST['price'.$i]);
	$descr=antisql($connect,$_POST['descr'.$i]);
	$cont=(int)antisql($connect,$_POST['cont'.$i]);
	
	function preg_grep_keys($pattern, $input, $flags = 0) 
	{
		return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
	}
	$a1=array_keys(preg_grep_keys("/^\d*\+\d*/", $_POST));
		
	if(isset($_POST['del'.$i]))
	{
		mysqli_query($connect, "DELETE FROM `emplserv` WHERE `id_serv`='$id'");
		mysqli_query($connect, "DELETE FROM `record` WHERE `id_serv`='$id'");
		$query=mysqli_query($connect, "DELETE FROM `service` WHERE `id`='$id'");
		if(mysqli_affected_rows($connect)>0)
		{
			$_SESSION['message']='Успешно удалено';
			header('Location: ../../services.php');
			exit;
		}
		else
		{
			$_SESSION['message']='Ошибка удаления';
			header('Location: ../../admin/editservice.php');
			exit;
		}
	}
	else if(isset($_POST['chang'.$i]))
	{
		mysqli_query($connect, "DELETE FROM `emplserv` WHERE `id_serv`='$id'");
		for($i=0;$i<count($a1, COUNT_RECURSIVE);$i++)
		{
			$pos=strpos($a1[$i], "+");
			$id_serv=(int)antisql($connect,substr($a1[$i],0,$pos));
			if($id_serv!=$id)
				continue;
			$id_empl=(int)antisql($connect,substr($a1[$i],$pos+1,strlen($a1[$i])));
			$query=mysqli_query($connect, "INSERT INTO `emplserv` (`id`, `id_serv`, `id_empl`) VALUES(NULL, '$id_serv', '$id_empl')");
			if(mysqli_affected_rows($connect)==0)
			{
				$_SESSION['message']='Ошибка создания связи';
				header('Location: ../../admin/editservice.php');
				exit;
			}
		} 
		$query=mysqli_query($connect, "UPDATE `service` SET `name`='$name', `price`='$price', `descr`='$descr', `cont`='$cont' WHERE `id`='$id'");
		if($query)
		{
			$_SESSION['message']='Успешно изменено';
			header('Location: ../../services.php');
			exit;
		}
		else
		{
			$_SESSION['message']='Ошибка изменения';
			header('Location: ../../admin/editservice.php');
			exit;
		}
	}
	mysqli_close($connect);
?>