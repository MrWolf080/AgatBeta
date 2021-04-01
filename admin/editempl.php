<?php
	session_start();
	require_once '../lk/vendor/db_connection.php';
?>
<link rel="stylesheet" href="../styles/stylelog.css" type="text/css">
<?php	
	if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
	{
		echo 'У вас нет прав для работы с этой страницей<br>';
		echo '<a href="../index.php">На главную</a>';
		exit;
	}
	$count_empl=mysqli_query($connect, "SELECT COUNT(*) FROM `empl`");
	if(mysqli_fetch_array($count_empl)[0]==0)
		echo "Сотрудников пока нет.<br>";
	
	$query=mysqli_query($connect, "SELECT * FROM `empl`");
?>
<form action="../lk/vendor/editempl.php" method="post" enctype="multipart/form-data">
	<div class="message">
		<?php
			if($_SESSION['message'])
			{
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
		?>
	</div>
    <h1>Редактирование сотрудника</h1>
	<div class="haveacc">
		<?php
			$n=mysqli_num_rows($query);
			for($i=1;$i<=$n;$i++)
			{
				$arr=mysqli_fetch_assoc($query);
				$id=$arr['id'];
				$fio=$arr['fio'];
				$email=$arr['email'];
				$descr=$arr['descr'];
				echo '<input type="file" name="image'.$i.'" /><br>';
				echo '<img src="data:image/*;base64,'.base64_encode($arr['photo']).'" /><br>';
				echo '<input type="text" value="'.$fio.'" name="fio'.$i.'"><br>';
				echo '<input type="hidden" name='.$i.' value='.$id.'>';
				echo '<input type="text" value="'.$email.'" name="email'.$i.'"><br>';
				echo '<input type="text" value="'.$descr.'" name="descr'.$i.'"><br>';
				$query2=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
				if(mysqli_num_rows($query2)>0)
				{
					while($serv_arr=mysqli_fetch_assoc($query2))
					{
						$id_serv=$serv_arr['id'];
						$name=$serv_arr['name'];
						$query1=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_empl`='$id' AND `id_serv`='$id_serv'");
						if(mysqli_num_rows($query1)>0)
						{
							echo '<input type="checkbox" name="'.$id.'+'.$id_serv.'" checked>'.$name.'<br>';
						}
						else
							echo '<input type="checkbox" name="'.$id.'+'.$id_serv.'" >'.$name.'<br>';
					}
				}
				echo '<button type="submit" name="chang'.$i.'">Изменить</button>';
				echo '<button type="submit" name="del'.$i.'">Удалить</button><br><br>';
			}
		?>
		
	</div>
</form>
<?php
	
	if($_SESSION['user'])
			if($_SESSION['user']['role']==3)
				echo '<a href="addempl.php">Добавить сотрудника</a>';
	mysqli_close($connect);
?>