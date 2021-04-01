<?php
	session_start();
	require_once 'db_connection.php';
	
	$id_serv=(int)antisql($connect, $_POST['id_serv']);
	$id_empl=(int)antisql($connect, $_POST['id_empl']);
	if(!$_SESSION['user'])
	{
		$_SESSION['message']="Записаться можно только авторизованным пользователям";
		header("Location: ../../records.php");
		exit;
	}
	$date=antisql($connect, $_POST['date']);
	$time=antisql($connect, $_POST['time']);
	$datetime=$date." ".$time;
	$id_user=antisql($connect, $_SESSION['user']['id']);
	if(mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `record` WHERE `date`='$datetime' AND `id_user`='$id_user' AND `id_serv`='$id_serv' AND `id_empl`='$id_empl'"))==0)
	{
		mysqli_query($connect, "INSERT INTO `record` (`id`, `date`,`id_user`, `id_serv`, `id_empl`) VALUES (NULL, '$datetime','$id_user', '$id_serv','$id_empl')");
		if(mysqli_affected_rows($connect)==0)
		{
			$_SESSION['message']="Неизвестная ошибка записи";
			header("Location: ../../records.php");
			exit;
		}
		else
		{
			$_SESSION['message']="Вы успешно записаны";
			header("Location: ../../records.php");
			exit;
		}
	}
	mysqli_close($connect);
	header("Location: ../../records.php");
	exit;
?>