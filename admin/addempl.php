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
?>
<form action="../lk/vendor/addempl.php" method="post"  enctype="multipart/form-data">
	<div class="message">
		<?php
			if($_SESSION['message'])
			{
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
		?>
	</div>
    <h1>Добавление сотрудника</h1>
	<div class="haveacc">
		<label>ФИО</label>
		<br>
		<input type="text" name="fio" placeholder="Введите ФИО сотрудника">
		 <br>
		<label>Почта</label>
		 <br>
		<input type="email" name="email" placeholder="Введите адрес почты сотрудника">
		 <br>
		<label>Описание</label>
		 <br>
		<input type="text" name="descr" placeholder="Введите описание">
		 <br>
		<label>Фото</label>
		 <br>
		<input type="file" name="image" />
		 <br>
		 <?php
			$q=mysqli_query($connect, "SELECT `id`, `name` FROM `service`");
			if(mysqli_num_rows($q)>0)
			{
				echo '<label>Услуги, выполняемые этим сотрудником</label><br>';
				while($empl=mysqli_fetch_assoc($q))
				{
					$id=$empl['id'];
					$name=$empl['name'];
					echo '<input type="checkbox" name="'.$id.'">'.$name.'<br>';
				}
			}
		 ?>
		<button type="submit">Добавить</button>
	</div>
</form>
<?php
	mysqli_close($connect);
?>
