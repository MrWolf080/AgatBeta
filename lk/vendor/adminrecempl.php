<?php
	session_start();
	require_once 'db_connection.php';
	
	
	$id=1;
	while(!isset($_POST['chang'.$id])&&!isset($_POST['del'.$id])&&!isset($_POST['show'.$id]))
		$id++;
	
	$date=antisql($connect, $_POST['date'.$id]);
	$time=antisql($connect, $_POST['time'.$id]);
	$id_user=(int)antisql($connect, $_POST['user'.$id]);
	$id_serv=(int)antisql($connect, $_POST['serv'.$id]);
	$datetime=$date.' '.$time;
	
	if(isset($_POST['chang'.$id]))
	{
		if($id_user==0&&$id_serv==0)
		{
			$query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime' WHERE `id`='$id'");
			if($query)
			{
				$_SESSION['message']='Успешно изменено';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
			else
			{
				$_SESSION['message']='Ошибка измененения';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
		}
		else if($id_user==0)
		{
			$query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_serv`='$id_serv' WHERE `id`='$id'");
			if($query)
			{
				$_SESSION['message']='Успешно изменено';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
			else
			{
				$_SESSION['message']='Ошибка измененения';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
		}
		else if($id_serv==0)
		{
			$query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_user`='$id_user' WHERE `id`='$id'");
			if($query)
			{
				$_SESSION['message']='Успешно изменено';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
			else
			{
				$_SESSION['message']='Ошибка измененения';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
		}
		else
		{
			$query=mysqli_query($connect, "UPDATE `record` SET `date`='$datetime', `id_serv`='$id_serv', `id_user`='$id_user' WHERE `id`='$id'");
			if($query)
			{
				$_SESSION['message']='Успешно изменено';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
			else
			{
				$_SESSION['message']='Ошибка измененения';
				header('Location: ../../admin/recordsempl.php');
				exit;
			}
		
		}
	}
	else if(isset($_POST['del'.$id]))
	{
		$query=mysqli_query($connect, "DELETE FROM `record` WHERE `id`='$id'");
		if(mysqli_affected_rows($connect)>0)
		{
			$_SESSION['message']='Успешно удалено';
			header('Location: ../../admin/recordsempl.php');
			exit;
		}
		else
		{
			$_SESSION['message']='Ошибка удаления';
			header('Location: ../../admin/recordsempl.php');
			exit;
		}
	}
	else if(isset($_POST['show'.$id]))
	{
		$query=mysqli_query($connect, "SELECT * FROM `user` WHERE `id` = (SELECT `id_user` FROM `record` WHERE `id`='$id')");
		$user=mysqli_fetch_assoc($query);
		$user_id=$user['id'];
		$fio=$user['fio'];
		$email=$user['email'];
		$tel=$user['tel'];
		?>
		<?php
			echo $user_id.'<br>';
			echo $fio.'<br>';
			echo $email.'<br>';
			echo $tel.'<br>';
		?>
		<?php
	}
?>
<?php
	mysqli_close($connect);
?>