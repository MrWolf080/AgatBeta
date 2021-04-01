<?php
	session_start();
	require_once 'db_connection.php';
	
	if(array_key_exists("timeset", $_POST))
	{
		$begin=antisql($connect, $_POST['begin']);
		$end=antisql($connect, $_POST['end']);
		$space=(int)antisql($connect, $_POST['space']);
		$query=mysqli_query($connect, "UPDATE `settings` SET `begin`='$begin', `end`='$end', `space`='$space' WHERE `id`='1'");
		if($query)
		{
			$_SESSION['message']='Успешно изменено';
			header('Location: ../../settings.php');
			exit;
		}
		else
		{
			$_SESSION['message']='Ошибка изменения';
			header('Location: ../../settings.php');
			exit;
		}
	}
	else if(array_key_exists("setrole", $_POST))
	{
		$id=(int)antisql($connect, $_POST['user']);
		$role=(int)antisql($connect, $_POST['role']);
		$query=mysqli_query($connect, "UPDATE `user` SET `role`='$role' WHERE `id`='$id'");
		if($query)
		{
			$_SESSION['message']='Успешно изменено';
			header('Location: ../../settings.php');
			exit;
		}
		else
		{
			$_SESSION['message']='Ошибка изменения';
			header('Location: ../../settings.php');
			exit;
		}
	}
	else if(array_key_exists("setrole", $_POST))
	{
		$id=(int)antisql($connect, $_POST['user']);
		mysqli_query($connect, "DELETE FROM `recors` WHERE `id_user`='$id'");
		$query=mysqli_query($connect, "DELETE FROM `user` WHERE `id`='$id'");
		if(mysqli_affected_rows($connect)>0)
		{
			$_SESSION['message']='Успешно удалено';
			header('Location: ../../settings.php');
			exit;
		}
		else
		{
			$_SESSION['message']='Ошибка удаления';
			header('Location: ../../settings.php');
			exit;
		}
	}
	mysqli_close($connect);
?>