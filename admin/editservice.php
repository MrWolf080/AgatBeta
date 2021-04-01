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
	$count_empl=mysqli_query($connect, "SELECT COUNT(*) FROM `service`");
	if(mysqli_fetch_array($count_empl)[0]==0)
		echo "Услуг пока нет.<br>";
	
	$query=mysqli_query($connect, "SELECT * FROM `service`");
?>
<form action="../lk/vendor/editservice.php" method="post" enctype="multipart/form-data">
	<div class="message">
		<?php
			if($_SESSION['message'])
			{
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
		?>
	</div>
    <h1>Редактирование услуги</h1>
	<div class="haveacc">
		<?php
			$n=mysqli_num_rows($query);
			for($i=1;$i<=$n;$i++)
			{
				$arr=mysqli_fetch_assoc($query);
				$id=$arr['id'];
				$name=$arr['name'];
				$price=$arr['price'];
				$descr=$arr['descr'];
				$cont=$arr['cont'];
				echo '<input type="text" value="'.$name.'" name="name'.$i.'"><br>';
				echo '<input type="hidden" name='.$i.' value='.$id.'>';
				echo '<input type="text" value="'.$descr.'" name="descr'.$i.'"><br>';
				echo '<input type="text" value="'.$price.'" name="price'.$i.'"><br>';
				echo '<input type="text" value="'.$cont.'" name="cont'.$i.'"><br>';
				$query2=mysqli_query($connect, "SELECT `id`, `fio` FROM `empl`");
				if(mysqli_num_rows($query2)>0)
				{
					while($empl_arr=mysqli_fetch_assoc($query2))
					{
						$id_empl=$empl_arr['id'];
						$fio=$empl_arr['fio'];
						$query1=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_serv`='$id' AND `id_empl`='$id_empl'");
						if(mysqli_num_rows($query1)>0)
						{
							echo '<input type="checkbox" name="'.$id.'+'.$id_empl.'" checked>'.$fio.'<br>';
						}
						else
							echo '<input type="checkbox" name="'.$id.'+'.$id_empl.'" >'.$fio.'<br>';
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
				echo '<a href="addempl.php">Добавить услугу</a>';
	mysqli_close($connect);
?>