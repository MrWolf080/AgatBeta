<?php
	session_start();
	require_once 'lk/vendor/db_connection.php';
	
?>
<?php
	if(!$_SESSION['user']||$_SESSION['user']['role']!=3)
	{
		echo 'У вас нет прав для работы с этой страницей<br>';
		echo '<a href="../index.php">На главную</a>';
		exit;
	}
?>
<?php
	if($_SESSION['message'])
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
?>
Настройки сайта<br>
<form action="lk/vendor/settings.php" method="post">
	<?php
		$set=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `settings`"));
		$begin=substr($set['begin'],0,5);
		$end=substr($set['end'],0,5);
		$space=$set['space'];
		echo 'Время работы: ';
		echo '<input type="time" name="begin" value="'.$begin.'"> - <input type="time" name="end" value="'.$end.'">';
		echo '   Интервал: ';
		echo '<input type="text" name="space" value="'.$space.'">';
	?>
	<input type="submit" name="timeset" value="Изменить"><br>
</form>
Изменить права пользователя<br>
<form action="lk/vendor/settings.php" method="post">
	<input list="user" name="user" autocomplete="off">
	<datalist id="user">
	<?php
		$users=mysqli_query($connect, "SELECT `id`,`fio`,`role` FROM `user`");
		while($user=mysqli_fetch_assoc($users))
		{
			$id=$user['id'];
			$fio=$user['fio'];
			$role=$user['role'];
			echo '<option value="'.$id.'">'.$fio.'</option>';
		}
	?>
	</datalist>
	<br>
	<input type="radio" name="role" value="1">Пользователь</input>
	<input type="radio" name="role" value="2">Менеджер</input>
	<input type="radio" name="role" value="3">Администратор</input>
	<input type="submit" name="setrole" value="Изменить"><br>
</form>

Удалить пользователя<br>
<form action="lk/vendor/settings.php" method="post">
	<input list="user" name="user" autocomplete="off">
	<datalist id="user">
	<?php
		$users=mysqli_query($connect, "SELECT `id`,`fio`,`role` FROM `user`");
		while($user=mysqli_fetch_assoc($users))
		{
			$id=$user['id'];
			$fio=$user['fio'];
			$role=$user['role'];
			echo '<option value="'.$id.'">'.$fio.'</option>';
		}
	?>
	</datalist>
	<input type="submit" name="delete" value="Удалить"><br>
</form>
<a href="index.php">На главную</a>
<?php
	mysqli_close($connect);
?>