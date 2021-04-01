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
<form action="../lk/vendor/addservice.php" method="post">
	<div class="message">
		<?php
			if($_SESSION['message'])
			{
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}
		?>
	</div>
    <h1>Добавление услуги</h1>
	<div class="haveacc">
		<label>Название</label>
		<br>
		<input type="text" name="name" placeholder="Введите название">
		 <br>
		<label>Описание</label>
		 <br>
		<input type="text" name="descr" placeholder="Введите описание">
		 <br>
		<label>Цена</label>
		 <br>
		<input type="text" name="price" placeholder="Введите цену">
		 <br>
		<label>Средняя продолжительность в минутах</label>
		 <br>
		<input type="text" name="cont" placeholder="Введите продолжительность">
		 <br>
		 <?php
			$q=mysqli_query($connect, "SELECT `id`, `fio` FROM `empl`");
			if(mysqli_num_rows($q)>0)
			{
				echo '<label>Сотрудники, выполняющие эту услугу</label><br>';
				while($empl=mysqli_fetch_assoc($q))
				{
					$id=$empl['id'];
					$fio=$empl['fio'];
					echo '<input type="checkbox" name="'.$id.'">'.$fio.'<br>';
				}
			}
		 ?>
		<button type="submit">Добавить</button>
	</div>
</form>
<?php
	mysqli_close($connect);
?>