<?php
	session_start();
	require_once '../lk/vendor/date.php';
?>
<?php
	if($_SESSION['message'])
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
?>
<?php	
	if(!$_SESSION['user']||!$_SESSION['user']['role']>1)
	{
		echo 'У вас нет прав для работы с этой страницей<br>';
		echo '<a href="../index.php">На главную</a>';
		exit;
	}
?>
<form name='qqq' action="" method="post">
	<input type="date" name="date" value="<?php
											if(isset($_POST['date']))
												echo $_POST['date'];
										?>">
	<select name="empl" >
		<option value="<?php 
							if(isset($_POST['empl']))
								echo $_POST['empl'];
						?>">
						<?php   
						if(isset($_POST['empl']))
						{ 
							$id_empl=antisql($connect,$_POST['empl']);
							$fio=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `fio` FROM `empl` WHERE `id`='$id_empl'"))['fio'];
							echo $fio;
						}
						?>
						
		</option>
			<?php
				$query=mysqli_query($connect, "SELECT `id`, `fio` FROM `empl`");
				while($empl=mysqli_fetch_assoc($query))
				{
					$id_empl=$empl['id'];
					$fio=$empl['fio'];
					echo '<option value="'.$id_empl.'" name="'.$fio.'">'.$fio.'</option>';
				}
			?>
	</select>
	<input type="submit" value="Show records">
</form>
<form action="../lk/vendor/adminrecempl.php" method="post">
	<?php
		if(isset($_POST['empl'])&&isset($_POST['date']))
		{
			$datesql=antisql($connect, $_POST['date']).'%';
			$date=antisql($connect, $_POST['date']);
			$id_empl=(int)antisql($connect, $_POST['empl']);
			$query=mysqli_query($connect, "SELECT * FROM `record` WHERE `id_empl` = '$id_empl' AND `date` LIKE '$datesql'");
			if(mysqli_num_rows($query)==0)
				echo 'Записей нет';
			while($rec=mysqli_fetch_assoc($query))
			{
				$id_serv=$rec['id_serv'];
				$id_user=$rec['id_user'];
				$id=$rec['id'];
				$time=substr($rec['date'],11,5);
				echo '<input type="date" name="date'.$id.'" value="'.$date.'">';
				
				$length=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `cont` FROM `service` WHERE `id`='$id_serv'"))['cont'];
				$endtime=add_minutes_time($time, $length);
				echo '<input type="time" name="time'.$id.'" value="'.$time.'"> - <input type="time" name="endtime'.$id.'" value="'.$endtime.'">';
				
				$users=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`fio` FROM `user` WHERE `id`='$id_user'"));
				$usfio=$users['fio'];
				$usid=$users['id'];
				echo '<input list="user" id="user'.$id.'" autocomplete="off" name="user'.$id.'" value="'.$usfio.'">';
				echo '<datalist id="user" >';
				$query1=mysqli_query($connect, "SELECT * FROM `user`");
				while($user=mysqli_fetch_assoc($query1))
				{
					$user_fio=$user['fio'];
					$user_id=$user['id'];
					echo '<option value="'.$user_id.'">'.$user_fio.'</option>';
					
				}
				echo '</datalist>';
				
				$services=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`name` FROM `service` WHERE `id`='$id_serv'"));
				$name=$services['name'];
				$servid=$services['id'];
				echo '<input list="serv" autocomplete="off" name="serv'.$id.'" value="'.$name.'">';
				echo '<datalist id="serv" >';
				$query2=mysqli_query($connect, "SELECT * FROM `service`");
				while($serv=mysqli_fetch_assoc($query2))
				{
					$serv_name=$serv['name'];
					$serv_id=$serv['id'];
					echo '<option value="'.$serv_id.'">'.$serv_name.'</option>';
				}
				echo '</datalist>';
				
				echo '<input type="submit" name="show'.$id.'" value="Show user">';
				echo '<input type="submit" name="chang'.$id.'" value="Change">';
				echo '<input type="submit" name="del'.$id.'" value="Delete">';
				echo '<br>';
			}
		}
	?>
</form>
<?php
	mysqli_close($connect);
?>
