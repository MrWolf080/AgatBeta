<?php
	session_start();
	require_once 'db_connection.php';
	
	if(array_key_exists("timeset", $_POST))
	{
		$begin=antisql($connect, $_POST['begin']);
		$end=antisql($connect, $_POST['end']);
		$space=(int)antisql($connect, $_POST['space']);
		if($space<=0)
		{
			$_SESSION['bad_message']='Интервал должен быть положительным';
			header('Location: ../../settings.php');
			exit;
		}
		$query=mysqli_query($connect, "UPDATE `settings` SET `begin`='$begin', `end`='$end', `space`='$space' WHERE `id`='1'");
		if($query)
		{
			$_SESSION['good_message']='Успешно изменено';
			header('Location: ../../settings.php');
			exit;
		}
		else
		{
			$_SESSION['bad_message']='Ошибка изменения';
			header('Location: ../../settings.php');
			exit;
		}
	}
	else if(array_key_exists("setrole", $_POST))
	{
		$id=(int)antisql($connect, $_POST['user_role']);
		if(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) FROM `user` WHERE `id`='$id'"))[0]==0)
		{
			$_SESSION['bad_message']='Нет такого пользователя';
			header('Location: ../../settings.php');
			exit;
		}
		$role=(int)antisql($connect, $_POST['role']);
		$query=mysqli_query($connect, "UPDATE `user` SET `role`='$role' WHERE `id`='$id'");
		if($query)
		{
			$_SESSION['good_message']='Успешно изменено';
			header('Location: ../../settings.php');
			exit;
		}
		else
		{
			$_SESSION['bad_message']='Ошибка изменения';
			header('Location: ../../settings.php');
			exit;
		}
	}
	else if(array_key_exists("delete", $_POST))
	{
		
		
		$id=(int)antisql($connect, $_POST['user_del']);
		if(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) FROM `user` WHERE `id`='$id'"))[0]==0)
		{
			$_SESSION['bad_message']='Нет такого пользователя';
			header('Location: ../../settings.php');
			exit;
		}
		mysqli_query($connect, "DELETE FROM `record` WHERE `id_user`='$id'");
		$query=mysqli_query($connect, "DELETE FROM `user` WHERE `id`='$id'");
		if(mysqli_affected_rows($connect)>0)
		{
			$_SESSION['good_message']='Успешно удалено';
			header('Location: ../../settings.php');
			exit;
		}
		else
		{
			$_SESSION['bad_message']='Ошибка удаления';
			header('Location: ../../settings.php');
			exit;
		}
	}
	mysqli_close($connect);
?>