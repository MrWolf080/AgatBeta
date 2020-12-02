<?php
	require_once 'db_connection.php';
	
	$fio=$_POST['fio'];
	$email=$_POST['email'];
	$tel=$_POST['tel'];
	$password=$_POST['password'];
	$pass_conf=$_POST['pass_conf'];
	
	if($password!=$pass_conf)
	{
		die('Ошибка: Пароли не совпадают');
	}
	
	echo "1234567809";
?>