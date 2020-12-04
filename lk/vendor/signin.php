<?php
	session_start();
	require_once 'db_connection.php';
	
	$fio=$_POST['fio'];
	$pass=md5($_POST['password']);
	
	$check_user=mysqli_query($connect, "SELECT * FROM `user` WHERE (`fio`='$fio' OR `email`='$fio') AND `password`='$pass'");
	if(!$check_user)
	{
		$_SESSION['message']='Неизвестная ошибка';
		header('Location: ../auth.php');
		exit;
	}
	
	if(!(mysqli_num_rows($check_user)>0))
	{
		$_SESSION['message']='Ошибка: неверны ФИО, email или пароль';
		header('Location: ../auth.php');
		exit;
	}
	
	$user=mysqli_fetch_assoc($check_user);
	$_SESSION['user']=
	[
		"id"=>$user['id'],
		"fio"=>$user['fio'],
		"email"=>$user['email']
	];
	
	header('Location: ../../index.php');
?>